<?php
class Sonali_Collection_Adminhtml_CollectionController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
    	$this->_title($this->__('Collection'))
             ->_title($this->__('Manage Collections'));
       	$this->loadLayout();
       	$this->_addContent($this->getLayout()->createBlock('collection/adminhtml_collection'));
	   	$this->renderLayout();
    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('collection/collection')
            ->_addBreadcrumb(Mage::helper('collection')->__('Collection Manager'), Mage::helper('collection')->__('Collection Manager'))
            ->_addBreadcrumb(Mage::helper('collection')->__('Manage collection'), Mage::helper('collection')->__('Manage collection'))
        ;
        return $this;
    }
    

    public function editAction()
    {
        $this->_title($this->__('Collection'))
             ->_title($this->__('Collections'))
             ->_title($this->__('Edit Collections'));

        $id = $this->getRequest()->getParam('collection_id');
        $model = Mage::getModel('collection/collection');

        if ($id) {
            $model->load($id);
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Collection'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('collection_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('collection')->__('Edit Collection')
                    : Mage::helper('collection')->__('New Collection'),
                $id ? Mage::helper('collection')->__('Edit Collection')
                    : Mage::helper('collection')->__('New Collection'));

        $this->_addContent($this->getLayout()->createBlock('collection/adminhtml_collection_edit'))
                ->_addLeft($this->getLayout()->createBlock('collection/adminhtml_collection_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        try {
            $model = Mage::getModel('collection/collection');
            $data = $this->getRequest()->getPost('collection');
            $collectionId = $this->getRequest()->getParam('id');
            if (!$collectionId)
            {
                $collectionId = $this->getRequest()->getParam('collection_id');
            }

            if ($model->getId()) {
                $model->created_at = now();
            }else{
                $model->updated_at = now();
            }
            $model->setData($data)->setId($collectionId);
            $model->save();
            if(isset($_FILES['image']['name'])) {
                try {
                    $uploader = new Varien_File_Uploader('image');
                    $uploader->setAllowedExtensions(array('jpg','jpeg','png')); // or pdf or anything
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    $path = Mage::getBaseDir('media') . DS . 'collection' . DS;
                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    if ($uploader->save($path, $model->getId().'.'.$ext)) {
                        $model->image = 'collection/'.$model->getId().'.'.$ext;
                        $model->save();
                    }
                }catch(Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('collection')->__('Collection was successfully saved'));
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
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('collection_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('collection')->__('Unable to find collection to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('collection_id') > 0 ) {
            try {
                $model = Mage::getModel('collection/collection');
                 
                $model->setId($this->getRequest()->getParam('collection_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Collection was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('collection_id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $collectionIds = $this->getRequest()->getParam('collection');
        if(!is_array($collectionIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Collection(s).'));
        } else {
            try {
                $collection = Mage::getModel('collection/collection');
                foreach ($collectionIds as $collectionId) {
                    $collection
                        ->load($collectionId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($collectionIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}