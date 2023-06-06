
<?php
class Sonali_Banner_Adminhtml_Banner_GroupController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
    	$this->_title($this->__('Banner'))
             ->_title($this->__('Manage Banner Groups'));
       	$this->loadLayout();
       	$this->_addContent($this->getLayout()->createBlock('banner/adminhtml_banner_group'));
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

        $id = $this->getRequest()->getParam('group_id');
        $model = Mage::getModel('banner/group');
        Mage::register('banner',$model);

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

        $this->_addContent($this->getLayout()->createBlock('banner/adminhtml_banner_group_edit'))
                ->_addLeft($this->getLayout()->createBlock('banner/adminhtml_banner_group_edit_tabs'));

        $this->renderLayout();
    }

    public function saveAction()
    {
        try {
            echo "<pre>";
            $groupId = $this->getRequest()->getParam('id');
            $data = $this->getRequest()->getPost('group');
            $model = Mage::getModel('banner/group')->load($groupId);
            $groupId = $this->getRequest()->getParam('id');
            if (!$groupId)
            {
                $groupId = $this->getRequest()->getParam('group_id');
            }
            $model->setData($data)->setId($groupId);
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->created_at = date('Y-m-d H:i:s');
            } 
            else {
                $model->setUpdateTime(now());
            }
            $model->save();

            $positions = $this->getRequest()->getPost('position');
            $bannerModel = Mage::getModel('banner/banner');
            $statues = $this->getRequest()->getPost('status');
            foreach ($positions as $id => $position) 
            {
                $bannerModel->load($id);
                $bannerModel->setPosition($position);
                if (!$statues[$id]) 
                {
                    $statues[$id] = 2;
                }
                $bannerModel->setStatus($statues[$id]);
                $bannerModel->save();
            }
            
            $removes = $this->getRequest()->getPost('remove');
            foreach ($removes as $id => $remove) 
            {
                $bannerModel->load($id);
                $bannerModel->delete();
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

    public function uploadAction()
    {
    try {
        
        $id = $this->getRequest()->getParam('group_id');
        $bannerGroupModel = Mage::getModel('banner/group')->load($id);
                    $width = $bannerGroupModel->width;
                    $height = $bannerGroupModel->height;
        foreach ($_FILES['file']['tmp_name'] as $index => $tmpName) {
            $uploader = new Mage_Core_Model_File_Uploader('file[' . $index . ']');
            $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);

            $uploadDir = Mage::getBaseDir('media') . DS . 'banner' . DS . 'original';
            $uploadResizedDir = Mage::getBaseDir('media') . DS . 'banner' . DS . 'resized';
            $uploader->save($uploadDir, $images['name'][$index]);

            $uploadedFilePath = $uploadDir . DS . $uploader->getUploadedFileName();
            $resizedFilePath = $uploadResizedDir . DS . $uploader->getUploadedFileName();

             $image = new Varien_Image($uploadedFilePath);
                    $image->keepAspectRatio(true);
                    $image->resize($width, $height);
                    $image->save($resizedFilePath);
                    $model = Mage::getModel('banner/banner');
                    $model->setImage('banner'.DS.'resized'.DS.$uploader->getUploadedFileName());
                    $model->group_id = $id;
                    $model->save();
        }

        } catch (Exception $e) {
            $result = array(
                'error' => $e->getMessage(),
                'errorcode' => $e->getCode());
        }

        $this->_redirect('*/*/edit',['group_id'=> $id]);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

}