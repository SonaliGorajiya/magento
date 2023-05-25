<?php

class Sonali_Brand_Adminhtml_BrandController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('brand/manage');
    }

    public function preDispatch()
    {
        $this->_setForcedFormKeyActions(array('delete', 'massDelete'));
        return parent::preDispatch();
    }

    public function indexAction()
    {
        // echo '<pre>';
        // $model = Mage::getModel('brand/brand')->load(2);
        // $model->name = 'vijay thakor';
        // $model->email = 'v@gmial.com';
        // $model->save();
        // print_r($model->getCollection()->toArray());
        // die();
        $this->loadLayout();
        $this->_setActiveMenu('brand/manage');
        $this->_title($this->__("Brand Grid"));
        $this->_addContent($this->getLayout()->createBlock('brand/adminhtml_brand'));
        $this->renderLayout();
    }


    public function newAction() {
        $this->_forward('edit');
    }   

    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        if (!$model = Mage::getModel('brand/brand')->load($id)){
            $model = Mage::getModel('brand/brand');
        }

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('brand_data', $model);
        $this->loadLayout();
        $this->_setActiveMenu('brand/items');
        $this->_addContent($this->getLayout()->createBlock(' brand/adminhtml_brand_edit'))
            ->_addLeft($this->getLayout()->createBlock('brand/adminhtml_brand_edit_tabs'));
        $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brand')->__('Brand does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        if ($this->getRequest()->getParam('back')) {
            $this->_redirect('*/*/edit', array('id' => $model->getId()));
            return;
        }

        if ($data = $this->getRequest()->getPost()) {
            $brand = $data['brand'];
            $model = Mage::getModel('brand/brand');
            $model->setData($brand)->setId($this->getRequest()->getParam('id'));
            try {
                if ($model->brand_id != null) {
                    $model->updated_at = date('Y-m-d H:i:s');
                } else {
                    $model->created_at = date('Y-m-d H:i:s');
                }
                
                $model->save();

                if (isset($_FILES['image']['name']) && ($_FILES['image']['name'] != '')) 
                {
                    try {
                        $uploader = new Varien_File_Uploader('image');
                        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png', 'webp'));
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);
                        
                        $path = Mage::getBaseDir('media') . DS . 'brand' . DS;
                        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        if ($uploader->save($path, $model->getId().'.'.$extension)) {
                            $model->image = $model->getId().".".$extension;
                            $model->save();
                            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brand')->__('Image was successfully uploaded'));
                        }
                        
                        // $imageName = $uploader->getUploadedFileName();

                    } catch (Exception $e) {
                        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    }
                }


                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brand')->__('Brand was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                 
                if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($brand);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brand')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }


    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('brand/brand');
                 
                $model->setId($this->getRequest()->getParam('id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Brand was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function exportCsvAction()
    {
        $fileName   = 'brands.csv';
        $content    = $this->getLayout()->createBlock('brand/adminhtml_brand_grid')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'brands.xml';
        $content    = $this->getLayout()->createBlock('brand/adminhtml_brand_grid')
            ->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }


    public function massDeleteAction()
    {
        $brandIDs = $this->getRequest()->getParam('brand_id');
        if(!is_array($brandIDs)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select brand(s).'));
        } else {
            try {
                $brand = Mage::getModel('brand/brand');
                foreach ($brandIDs as $brandId) {
                    $brand->reset()
                        ->load($brandId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($brandIDs))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

}