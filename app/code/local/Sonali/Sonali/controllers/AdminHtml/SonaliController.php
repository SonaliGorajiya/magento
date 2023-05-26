<?php

class Sonali_Sonali_Adminhtml_SonaliController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sonali/manage');
    }

    public function preDispatch()
    {
        $this->_setForcedFormKeyActions(array('delete', 'massDelete'));
        return parent::preDispatch();
    }

    public function indexAction()
    {
        // echo '<pre>';
        // $model = Mage::getModel('sonali/sonali')->load(2);
        // $model->name = 'vijay thakor';
        // $model->email = 'v@gmial.com';
        // $model->save();
        // print_r($model->getCollection()->toArray());
        // die();
        $this->loadLayout();
        $this->_setActiveMenu('sonali/manage');
        $this->_title($this->__("Sonali Grid"));
        $this->_addContent($this->getLayout()->createBlock('sonali/adminhtml_sonali'));
        $this->renderLayout();
    }


    public function newAction() {
        $this->_forward('edit');
    }   

    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        if (!$model = Mage::getModel('sonali/sonali')->load($id)){
            $model = Mage::getModel('sonali/sonali');
        }

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('sonali_data', $model);
        $this->loadLayout();
        $this->_setActiveMenu('sonali/items');
        $this->_addContent($this->getLayout()->createBlock(' sonali/adminhtml_sonali_edit'))
            ->_addLeft($this->getLayout()->createBlock('sonali/adminhtml_sonali_edit_tabs'));
        $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sonali')->__('sonali does not exist'));
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
            $sonali = $data['sonali'];
            $model = Mage::getModel('sonali/sonali');
            $model->setData($sonali)->setId($this->getRequest()->getParam('id'));
            try {
                if ($model->entity_id != null) {
                    $model->updated_at = date('Y-m-d H:i:s');
                } else {
                    $model->created_at = date('Y-m-d H:i:s');
                }
                
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('sonali')->__('sonali was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                 
                if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($sonali);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sonali')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }


    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('sonali/sonali');
                 
                $model->setId($this->getRequest()->getParam('id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Sonali was successfully deleted'));
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
        $fileName   = 'sonalis.csv';
        $content    = $this->getLayout()->createBlock('sonali/adminhtml_sonali_grid')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'sonalis.xml';
        $content    = $this->getLayout()->createBlock('sonali/adminhtml_sonali_grid')
            ->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }


    public function massDeleteAction()
    {
        $sonaliIDs = $this->getRequest()->getParam('entity_id');
        if(!is_array($sonaliIDs)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select sonali(s).'));
        } else {
            try {
                $sonali = Mage::getModel('sonali/sonali');
                foreach ($sonaliIDs as $sonaliId) {
                    $sonali->reset()
                        ->load($sonaliId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($sonaliIDs))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

}