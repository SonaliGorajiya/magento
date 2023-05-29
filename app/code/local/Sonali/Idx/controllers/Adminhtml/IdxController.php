<?php

class Sonali_Idx_Adminhtml_IdxController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('idx/idx')
            ->_addBreadcrumb(Mage::helper('idx')->__('idx Manager'), Mage::helper('idx')->__('idx Manager'))
            ->_addBreadcrumb(Mage::helper('idx')->__('Manage idx'), Mage::helper('idx')->__('Manage idx'))
        ;
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__('Idx'))->_title($this->__('Manage Idx'));
        $this->loadLayout();
        $this->_addContent(
            $this->getLayout()->createBlock('idx/adminhtml_idx', 'idx')
        );
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('idx'))
             ->_title($this->__('idxs'))
             ->_title($this->__('Edit idxs'));

        $id = $this->getRequest()->getParam('idx_id');
        $model = Mage::getModel('idx/idx');

        if ($id) {
            $model->load($id);
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New idx'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('idx_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('idx')->__('Edit idx')
                    : Mage::helper('idx')->__('New idx'),
                $id ? Mage::helper('idx')->__('Edit idx')
                    : Mage::helper('idx')->__('New idx'));

        $this->_addContent($this->getLayout()->createBlock('idx/adminhtml_idx_edit'))
                ->_addLeft($this->getLayout()->createBlock('idx/adminhtml_idx_edit_tabs'));

        $this->renderLayout();
    }

    public function importAction()
    {
        if (isset($_FILES['csv']['tmp_name']) && !empty($_FILES['csv']['tmp_name'])) {
            $csvFile = $_FILES['csv']['tmp_name'];
            $csvData = array_map('str_getcsv', file($csvFile));

            // Remove the header row
            unset($csvData[0]);
            $counter = 0;

            $importModel = Mage::getModel('idx/idx');
            foreach ($csvData as $data) {
                $counter ++;
                $importModel->setData('sku', $data[0]);
                $importModel->setData('name', $data[1]);
                $importModel->setData('price', $data[2]);
                $importModel->setData('cost', $data[3]);
                $importModel->setData('quantity', $data[4]);
                $importModel->setData('brand', $data[5]);
                $importModel->setData('collection', $data[6]);
                $importModel->setData('description', $data[7]);
                $importModel->setData('status', $data[8]);
                $importModel->setData('created_at', now());
                // $importModel->setData('updated_at', $data[10]);

                try {
                    $importModel->setId(null); // Set the ID as null to avoid update query
                    $importModel->save();
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            }

             Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were added.', $counter)
                );
        } else {
            Mage::getSingleton('adminhtml/session')->addError('No CSV file uploaded.');
        }

        $this->_redirect('*/*/index');
    }

    public function downloadAction()
    {
        $filePath = Mage::getModuleDir('', 'Hk_Productimport') . DS . 'data' . DS . 'example.xlsx';

        // Check if the file exists
        if (file_exists($filePath)) {
            $this->_prepareDownloadResponse('example.xlsx', file_get_contents($filePath));
        } else {
            $this->_forward('noRoute');
        }
    }

    public function brandAction()
    {
        try {
            $idx = Mage::getModel('idx/idx');
            $idxCollection = $idx->getCollection();
            $idxBrandNames = [];
        
            foreach ($idxCollection as $idx) {
                $idxBrandNames[] = $idx->getData('brand');
            }

            $newBrands = $idx->updateMainBrand(array_unique($idxBrandNames));
            foreach ($idxCollection as $idx) {
                $idxBrandName = $idx->getData('brand');
                $brandId = array_search($idxBrandName,$newBrands);
                $resource = Mage::getSingleton('core/resource');
                $connection = $resource->getConnection('core_write');
                $tableName = $resource->getTableName('import_product_idx');
                $condition = '`index` = '.$idx->index;
                $query = "UPDATE `{$tableName}` SET `brand_id` = {$brandId} WHERE {$condition}";
                $connection->query($query); 
            }

            Mage::getSingleton('adminhtml/session')->addSuccess('Brand is fine now');
            $this->_redirect('*/*/');
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    public function collectionAction()
    {
        try {
            $idx = Mage::getModel('idx/idx');
            $idxCollection = $idx->getCollection();
            $idxCollectionNames = [];
        
            foreach ($idxCollection as $idx) {
                $idxCollectionNames[] = $idx->getData('collection');
            }

            $newCollections = $idx->updateMainCollection(array_unique($idxCollectionNames));
            foreach ($idxCollection as $idx) {
                $idxCollectionName = $idx->getData('collection');
                $collectionId = array_search($idxCollectionName,$newCollections);
                $resource = Mage::getSingleton('core/resource');
                $connection = $resource->getConnection('core_write');
                $tableName = $resource->getTableName('import_product_idx');
                $condition = '`index` = '.$idx->index;
                $query = "UPDATE `{$tableName}` SET `collection_id` = {$collectionId} WHERE {$condition}";
                $connection->query($query); 
            }

            Mage::getSingleton('adminhtml/session')->addSuccess('Collection is fine now');
            $this->_redirect('*/*/');
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    public function productAction()
    {
        try {
            $idx = Mage::getModel('idx/idx');
            $idxCollection = $idx->getCollection();
            foreach ($idxCollection as $idx) {
                if (!$idx->checkBrand()) {
                    Mage::getSingleton('adminhtml/session')->addNotice('Brand is not fine');
                    $this->_redirect('*/*/');
                }

                if (!$idx->checkCollection()) {
                    Mage::getSingleton('adminhtml/session')->addNotice('Collection is not fine');                    
                    $this->_redirect('*/*/');
                }
            }

            $idxSku = [];
            foreach ($idxCollection as $idx) {
                $idxSku[] = $idx->getData('sku');
            }

            $newProducts = $idx->updateMainProduct(array_unique($idxSku));
            foreach ($idxCollection as $idx) {
                $idxSku = $idx->getData('sku');
                $productId = array_search($idxSku,$newProducts);
                $resource = Mage::getSingleton('core/resource');
                $connection = $resource->getConnection('core_write');
                $tableName = $resource->getTableName('import_product_idx');
                $condition = '`index` = '.$idx->index;
                $query = "UPDATE `{$tableName}` SET `product_id` = {$productId} WHERE {$condition}";
                $connection->query($query); 
            }
            Mage::getSingleton('adminhtml/session')->addSuccess('Product is fine now');
            $this->_redirect('*/*/');
        } catch (Exception $e) {
            
        }
    }
}
