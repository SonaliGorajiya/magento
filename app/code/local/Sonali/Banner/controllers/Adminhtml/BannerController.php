<?php
class Sonali_Banner_Adminhtml_BannerController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Banner'))
             ->_title($this->__('Manage Banners'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('banner/adminhtml_banner'));
        $this->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction() {
        $id = $this->getRequest()->getParam('banner_id');
        $model = Mage::getModel('banner/banner')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('banner_data', $model);
            $this->loadLayout();
            $this->_setActiveMenu('banner/items');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
            $this->_addContent($this->getLayout()->createBlock(' banner/adminhtml_banner_edit'))
                ->_addLeft($this->getLayout()
                ->createBlock('banner/adminhtml_banner_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('Banner does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        try {
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            $uploader = new Varien_File_Uploader('image');
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);

            $path = Mage::getBaseDir('media') . DS . 'Banner';
            $uploader->save($path);

            $filePath = $path . DS . $uploader->getUploadedFileName();
            }
            
            $bannerModel = Mage::getModel('banner/banner');
            $bannerData = $this->getRequest()->getPost('banner');
            $bannerModel->setData($bannerData)
                ->setId($this->getRequest()->getParam('id'));

            if ($bannerModel->banner_id == NULL) {
                $bannerModel->created_at = date("y-m-d H:i:s");
            } else {
                $bannerModel->updated_at = date("y-m-d H:i:s");
            }

            $bannerModel->addData(['image'=> $_FILES['image']['name']])->save();


            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('banner')->__('Banner was successfully saved'));
            Mage::getSingleton('adminhtml/session')->setFormData(true);

            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $bannerModel->getId()));
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
        $bannerIds = $this->getRequest()->getParam('banner_id');
        if(!is_array($bannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('Please select banner(s).'));
        } else {
            try {
                $model = Mage::getModel('banner/banner');
                foreach ($bannerIds as $bannerId) {
                    $model->load($bannerId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('banner')->__(
                    'Total of %d record(s) were deleted.', count($bannerIds)
                )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

}