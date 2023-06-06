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

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('banner/banner')
            ->_addBreadcrumb(Mage::helper('banner')->__('Banner Manager'), Mage::helper('banner')->__('Banner Manager'))
            ->_addBreadcrumb(Mage::helper('banner')->__('Manage banner'), Mage::helper('banner')->__('Manage banner'))
        ;
        return $this;
    }
    
    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('Banner'))
             ->_title($this->__('Banners'))
             ->_title($this->__('Edit Banners'));

        $id = $this->getRequest()->getParam('banner_id');
        $model = Mage::getModel('banner/banner');

        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('banner')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Banner'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('banner_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('banner')->__('Edit Banner')
                    : Mage::helper('banner')->__('New Banner'),
                $id ? Mage::helper('banner')->__('Edit Banner')
                    : Mage::helper('banner')->__('New Banner'));

        $this->_addContent($this->getLayout()->createBlock('banner/adminhtml_banner_edit'))
                ->_addLeft($this->getLayout()->createBlock('banner/adminhtml_banner_edit_tabs'));

        $this->renderLayout();
    }

    public function saveAction()
    {
        try {
            $model = Mage::getModel('banner/banner');
            $data = $this->getRequest()->getPost('banner');

            // echo "<pre>";
            // print_r($_FILES);die;

            $bannerId = $this->getRequest()->getParam('id');
            if (!$bannerId)
            {
                $bannerId = $this->getRequest()->getParam('banner_id');
            }

            $model->setData($data)->setId($bannerId);
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->created_at = date('Y-m-d H:i:s');
            } 
            else {
                $model->setUpdateTime(now());
            }
            $model->save();

            if (isset($_FILES['image']['name']) && ($_FILES['image']['name'] != '')) 
            {
                try {
                    $uploader = new Varien_File_Uploader('image');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png', 'webp'));
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    
                    $path = Mage::getBaseDir('media') . DS . 'banner' . DS;
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    if ($uploader->save($path, $model->getId().'.'.$extension)) {
                        $model->image = 'banner/'.$model->getId().".".$extension;
                        $model->save();
                        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('banner')->__('Image was successfully uploaded'));
                    }
                    
                    // $imageName = $uploader->getUploadedFileName();

                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            }

            
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('banner')->__('Banner was successfully saved'));
            Mage::getSingleton('adminhtml/session')->setFormData(false);
             
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
            }
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('banner_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('Unable to find banner to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('banner_id') > 0 ) {
            try {
                $model = Mage::getModel('banner/banner');
                 
                $model->setId($this->getRequest()->getParam('banner_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Banner was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('banner_id')));
            }
        }
        $this->_redirect('*/*/');
    }
}