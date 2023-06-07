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
        try {
            $brandModel = Mage::getModel('brand/brand');
            $brandData = $this->getRequest()->getPost('brand');
            $brandModel->setData($brandData)
                ->setId($this->getRequest()->getParam('id'))
                ->saveImage('image', Mage::getBaseDir('media') . DS . 'Brand')
                ->saveImage('banner', Mage::getBaseDir('media') . DS . 'Brand' . DS . 'Banner');


            if ($brandModel->brand_id == NULL) {
                $brandModel->created_at = date("y-m-d H:i:s");
            } else {
                $brandModel->updated_at = date("y-m-d H:i:s");
            }

            $brandModel->save();
            if ($brandModel->brand_id) {
                $brandModel->saveRewriteUrlKey();
            }

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brand')->__('Brand was successfully saved'));
            Mage::getSingleton('adminhtml/session')->setFormData(true);

            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $brandModel->getId()));
                return;
            }
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            return;
        }
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