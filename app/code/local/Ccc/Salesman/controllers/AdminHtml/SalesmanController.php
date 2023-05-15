<?php

class Ccc_Salesman_Adminhtml_SalesmanController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('salesman/manage');
    }

    public function preDispatch()
    {
        $this->_setForcedFormKeyActions(array('delete', 'massDelete'));
        return parent::preDispatch();
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_title($this->__("Salesman Grid"));
        $this->_addContent($this->getLayout()->createBlock('salesman/adminhtml_salesman'));
        $this->renderLayout();
    }


    public function newAction() {
        $this->_forward('edit');
    }   

    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        if (!$model1 = Mage::getModel('salesman/salesman')->load($id)){
            $model1 = Mage::getModel('salesman/salesman');
        }
        if (!$model2 = Mage::getModel('salesman/salesman_address')->load($id)){
            $model2 = Mage::getModel('salesman/salesman_address');
        }

        if ($model1->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model1->setData($data);
        }

        if ($model2->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        }
        if (!empty($data)) {
            $model2->setData($data);
        }
        Mage::register('salesman_data', $model1);
        Mage::register('salesman_address_data', $model2);
        $this->loadLayout();
        $this->_setActiveMenu('salesman/items');
        $this->_addContent($this->getLayout()->createBlock(' salesman/adminhtml_salesman_edit'))->_addLeft($this->getLayout()->createBlock('salesman/adminhtml_salesman_edit_tabs'));
        $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salesman')->__('Salesman does not exist'));
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
            $salesman = $data['salesman'];
            $address = $data['address'];
            $model = Mage::getModel('salesman/salesman');
            $addressModel = Mage::getModel('salesman/salesman_address');
            $model->setData($salesman)->setId($this->getRequest()->getParam('id'));
            $addressModel->setData($address);
            try {
                if ($model->salesman_id != null) {
                    $model->updated_at = date('Y-m-d H:i:s');
                    $model->save();
                    $addressModel->salesman_id = $model->salesman_id;
                } else {
                    $model->created_at = date('Y-m-d H:i:s');
                    $model->save();
                    $addressModel->salesman_id = $model->salesman_id;
                    $addressModel->getResource()->setPrimaryKey('address_id');
                }
                $addressModel->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('salesman')->__('Salesman was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                 
                if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($salesman);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salesman')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }


    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('salesman/salesman');
                 
                $model->setId($this->getRequest()->getParam('id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Salesman was successfully deleted'));
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
        $fileName   = 'salesmans.csv';
        $content    = $this->getLayout()->createBlock('salesman/adminhtml_salesman_grid')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'salesmans.xml';
        $content    = $this->getLayout()->createBlock('salesman/adminhtml_salesman_grid')
            ->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }


    public function massDeleteAction()
    {
        $salesmanIDs = $this->getRequest()->getParam('salesman_id');
        if(!is_array($salesmanIDs)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select salesmen.'));
        } else {
            try {
                $salesman = Mage::getModel('salesman/salesman');
                foreach ($salesmanIDs as $salesmanId) {
                    $salesman->reset()
                        ->load($salesmanId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($salesmanIDs))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

    public function massUpdateAction()
    {
        // $salesman_id = $this->getRequest()->getParam('id');
        // $data = $this->getRequest()->getPost();
        // echo "<pre>";
        // print_r($data);
        // print_r($salesman_id);
        // die;
        
    }

}