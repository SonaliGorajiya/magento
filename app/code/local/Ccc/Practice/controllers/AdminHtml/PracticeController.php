<?php

class Ccc_Practice_Adminhtml_PracticeController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('practice/manage');
    }

    public function preDispatch()
    {
        $this->_setForcedFormKeyActions(array('delete', 'massDelete'));
        return parent::preDispatch();
    }

    public function indexAction()
    {
        // echo '<pre>';
        // $model = Mage::getModel('practice/practice')->load(2);
        // $model->name = 'vijay thakor';
        // $model->email = 'v@gmial.com';
        // $model->save();
        // print_r($model->getCollection()->toArray());
        // die();
        $this->loadLayout();
        $this->_title($this->__("Product Grid"));
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_practice'));
        $this->renderLayout();
    }


    public function newAction() {
        $this->_forward('edit');
    }   

    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        if (!$model = Mage::getModel('practice/practice')->load($id)){
            $model = Mage::getModel('practice/practice');
        }

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('practice_data', $model);
        $this->loadLayout();
        $this->_setActiveMenu('practice/items');
        $this->_addContent($this->getLayout()->createBlock(' practice/adminhtml_practice_edit'))
            ->_addLeft($this->getLayout()->createBlock('practice/adminhtml_practice_edit_tabs'));
        $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice')->__('practice does not exist'));
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
            $practice = $data['product'];
            $model = Mage::getModel('practice/practice');
            $model->setData($practice)->setId($this->getRequest()->getParam('id'));
            try {
                if ($model->practice_id != null) {
                    $model->updated_at = date('Y-m-d H:i:s');
                } else {
                    $model->created_at = date('Y-m-d H:i:s');
                }
                
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('practice')->__('Product was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                 
                if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($practice);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }


    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('practice/practice');
                 
                $model->setId($this->getRequest()->getParam('id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Product was successfully deleted'));
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
        $fileName   = 'practices.csv';
        $content    = $this->getLayout()->createBlock('practice/adminhtml_practice_grid')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'practices.xml';
        $content    = $this->getLayout()->createBlock('practice/adminhtml_practice_grid')
            ->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }


    public function massDeleteAction()
    {
        $productIDs = $this->getRequest()->getParam('product_id');
        if(!is_array($productIDs)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Practice(s).'));
        } else {
            try {
                $practice = Mage::getModel('practice/practice');
                foreach ($productIDs as $productId) {
                    $practice->reset()
                        ->load($productId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($productIDs))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

}