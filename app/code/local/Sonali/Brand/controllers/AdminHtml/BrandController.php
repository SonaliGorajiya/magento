<?php
class Sonali_Brand_Adminhtml_BrandController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Brand'))
             ->_title($this->__('Manage Brands'));
        $this->loadLayout();
        $this->_setActiveMenu('brand/manage');
        $this->_addContent($this->getLayout()->createBlock('brand/adminhtml_brand'));
        $this->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction() {
        $id = $this->getRequest()->getParam('brand_id');
        $model = Mage::getModel('brand/brand')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('brand_data', $model);
            $this->loadLayout();
            $this->_setActiveMenu('brand/items');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
            $this->_addContent($this->getLayout()->createBlock(' brand/adminhtml_brand_edit'))
                ->_addLeft($this->getLayout()
                ->createBlock('brand/adminhtml_brand_edit_tabs'));
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
                ->saveImage('banner', Mage::getBaseDir('media') . DS . 'Brand' . DS . 'Banner')
                ->addData(['url_key' => strtolower(str_replace(' ', '-', $brandModel->name))]);

            if ($brandModel->brand_id == NULL) {
                $brandModel->created_at = date("y-m-d H:i:s");
            } else {
                $brandModel->updated_at = date("y-m-d H:i:s");
            }

            $brandModel->save();
                Mage::dispatchEvent('brand_save_after', array('brand' => $brandModel));
            
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

    public function massDeleteAction()
    {
        $brandIds = $this->getRequest()->getParam('brand_id');
        if(!is_array($brandIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brand')->__('Please select brand(s).'));
        } else {
            try {
                $model = Mage::getModel('brand/brand');
                foreach ($brandIds as $brandId) {
                    $model->load($brandId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('brand')->__(
                    'Total of %d record(s) were deleted.', count($brandIds)
                )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

}