<?php
class Sonali_Idx_Adminhtml_IdxController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        try{
            $this->_title($this->__('Idx'))
                 ->_title($this->__('Import Product Idxs'));
            $this->loadLayout();
            $this->_addContent($this->getLayout()->createBlock('idx/adminhtml_idx'));
            $this->renderLayout();
        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
    }

    public function editAction() {
        try{
                $this->getRequest()->getParam('index');
                $this->loadLayout();
                $this->_setActiveMenu('idx/items');
                $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
                $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
                $this->_addContent($this->getLayout()->createBlock(' idx/adminhtml_idx_edit'))
                    ->_addLeft($this->getLayout()
                    ->createBlock('idx/adminhtml_idx_edit_tabs'));
                $this->renderLayout();
            }catch(Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

    public function importAction()
    {
        try { 
            Mage::getModel('idx/idx')->truncate();
            $csvFile = $_FILES['import_options']['tmp_name'];
            $csvData = file_get_contents($csvFile);
            $csvData = array();

            if (($handle = fopen($csvFile, 'r')) !== false) {
                while (($data = fgetcsv($handle)) !== false) {
                    $row = array();
                    foreach ($data as $value) {
                        $row[] = $value;
                    }
                    $csvData[] = $row;
                }
                  fclose($handle);
            }

            $header = [];
            $idxModel = Mage::getModel('idx/idx');
            foreach ($csvData as $value)
            {
                if(!$header)
                {
                    $header = $value;
                }
                else
                {
                    $data = array_combine($header,$value);
                    $idxModel->insertOnDuplicate($data, array_keys($data));
                }
            }

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('idx')->__('Data Imported successfully.'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/adminhtml_idx/index'); 
    }

    
     public function brandAction()
    {
        try {
            $idx = Mage::getModel('idx/idx');       
            $idxCollection = $idx->getCollection();
            $idxCollectionArray = $idx->getCollection()->getData();

            $idxBrandId = array_column($idxCollectionArray,'index');
            $idxBrandNames = array_column($idxCollectionArray,'brand');
            $idxBrandNames = array_combine($idxBrandId,$idxBrandNames);
            
            $newBrands = $idx->updateBrandTable(array_unique($idxBrandNames));
            $idxCollection = $idx->getCollection();
            foreach ($idxCollection as $idx) {
                if(!$idx->brand_id)
                {
                    $brand = Mage::getModel('brand/brand');
                    $brandCollection = Mage::getModel('brand/brand')->getCollection();
                    $brandCollection->getSelect()->where('main_table.name=?',$idx->brand);
                    $brandData = $brandCollection->getData();
                    $resource = Mage::getSingleton('core/resource');
                    $connection = $resource->getConnection('core_write');
                    $tableName = $resource->getTableName('import_product_idx');
                    $condition = '`index` = '.$idx->index;
                    $query = "UPDATE `{$tableName}` SET `brand_id` = {$brandData[0]['brand_id']} WHERE {$condition}";
                    $connection->query($query); 
                }
            }
            Mage::getSingleton('adminhtml/session')->addSuccess('Brand is fine now');
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/index');
    }


    public function collectionAction()
    {
        try {
            $idx = Mage::getModel('idx/idx');  
            $idxCollection = $idx->getCollection();     
            $idxCollectionData = $idx->getCollection()->getData();

            $idxCollectionNames = array_column($idxCollectionData,'collection');
            $newCollections = $idx->updateCollectionOption(array_unique($idxCollectionNames));

            $resource = Mage::getSingleton('core/resource');
            $writeAdapter = $resource->getConnection('core_write');

            $idxTable = $resource->getTableName('idx/idx');
            $optionValueTable = $resource->getTableName('eav_attribute_option_value');

            $updateQuery = "
                UPDATE {$idxTable} p
                JOIN (
                    SELECT option_id,value
                    FROM {$optionValueTable}
                ) o ON p.`collection` = o.`value`
                SET p.`collection_id` = o.`option_id`
            ";

            $writeAdapter->query($updateQuery);
    
            Mage::getSingleton('adminhtml/session')->addSuccess('Collection is fine now');
        } catch (Exception $e) {
             Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    public function productAction()
    {
        try{
            $idxCollection = Mage::getModel('idx/idx')->getCollection(); 

            foreach ($idxCollection as $idxRow) {
                if (!$idxRow->brand_id) {
                    throw new Exception('Brand is not fine');
                }
                
                if (!$idxRow->collection_id) {
                    throw new Exception('Collection is not fine');
                }
            }

            foreach ($idxCollection as $idxRow) {
                $sku = $idxRow->sku;
                $productId = Mage::getResourceModel('catalog/product')->getIdBySku($sku);
                if ($productId) {
                    $sql = "UPDATE `import_product_idx` SET `product_id` = {$productId} WHERE `sku` = {$sku}";
                    $idxRow->query($sql);
                }
            }

            $missingProducts = $idxCollection->addFieldToFilter('product_id', 0);

            foreach ($missingProducts as $missingProduct) {
                $productData = [
                    'entity_type_id' => 4,
                    'attribute_set_id' => 4,
                    'type_id' => 'simple',
                    'sku' => $missingProduct->sku,
                    'has_option' => 0,
                    'required_options' => 0,
                    'name' => $missingProduct->name,
                    'price' => $missingProduct->price,
                    'status' => $missingProduct->status,
                    'visibility' => '4',
                    'created_at' => now()
                ];
                
                $storeId = Mage_Core_Model_App::ADMIN_STORE_ID;
                $product = Mage::getModel('catalog/product');
                $product->setStoreId($storeId)
                        ->setData($productData)
                        ->setStockData(array(
                                'is_in_stock' => 1,
                                'qty' => $missingProduct->quantity),
                            )
                        ->save();
                
                $sql = "UPDATE `import_product_idx` SET `product_id` = '{$product->entity_id}' WHERE `sku` = '{$product->sku}'";
                Mage::getModel('idx/idx')->query($sql) ;
            }

            $missingProductIds = $idxCollection->addFieldToFilter('product_id', 0);

            if ($missingProductIds->getData()) {
                throw new Exception('There are products without Product Ids.');
            }
            Mage::getSingleton('adminhtml/session')->addSuccess('Products are successfully imported');
        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/index');

    }

    public function massDeleteAction()
    {
        try { 
            $idxIds = $this->getRequest()->getParam('index');
            if(!is_array($idxIds)) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('idx')->__('Please select idx(s).'));
            } else {
                $model = Mage::getModel('idx/idx');
                foreach ($idxIds as $idxId) {
                    $model->load($idxId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('idx/idx')->__(
                    'Total of %d record(s) were deleted.', count($idxIds)
                )
                );
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('*/*/index');
    }
}