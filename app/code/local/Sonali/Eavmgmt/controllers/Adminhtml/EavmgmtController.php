<?php

class Sonali_Eavmgmt_Adminhtml_EavmgmtController extends Mage_Adminhtml_Controller_Action
{
    
    function indexAction()
    {

        $this->_title($this->__('Eavmgmt'))
             ->_title($this->__('Manage Eavmgmt'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('eavmgmt/adminhtml_eavmgmt'));
        $this->renderLayout();
        
    }

    public function newAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('Eavmgmt/items');
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
        $this->_addContent($this->getLayout()->createBlock(' eavmgmt/adminhtml_eavmgmt_edit'))->_addLeft($this->getLayout()->createBlock('eavmgmt/adminhtml_eavmgmt_edit_tabs'));
        $this->renderLayout();
    }

    public function editAction() 
    {
        $id = $this->getRequest()->getParam('attribute_id');
        $model = Mage::getModel('eavmgmt/eavmgmt')->load($id);

        if ($model->getId() || $id == 0) {
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
        $model->setData($data);
        }

        Mage::register('eavmgmt_data', $model);

        $this->loadLayout();
        $this->_setActiveMenu('eavmgmt/items');

        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

        $this->_addContent($this->getLayout()->createBlock('eavmgmt/adminhtml_eavmgmt_edit'))
        ->_addLeft($this->getLayout()
        ->createBlock('eavmgmt/adminhtml_eavmgmt_edit_tabs'));
        $this->renderLayout();
        } else {
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('eavmgmt')->__('Item does not exist'));
        $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        try {
            $model = Mage::getModel('eavmgmt/eavmgmt');
            $data = $this->getRequest()->getPost();
            
            if (!$this->getRequest()->getParam('attribute_id'))
            {
                $model->setData($data)->setId($this->getRequest()->getParam('attribute_id'));
            }

            $model->setData($data)->setId($this->getRequest()->getParam('attribute_id'));

            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            } 
            else {
                $model->setUpdateTime(now());
            }
             
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('eavmgmt')->__('Eavmgmt was successfully saved'));
            Mage::getSingleton('adminhtml/session')->setFormData(false);
             
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('attribute_id' => $model->getId()));
                return;
            }
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('attribute_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('eavmgmt')->__('Unable to find eavmgmt to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('attribute_id') > 0 ) {
            try {
                $model = Mage::getModel('eavmgmt/eavmgmt');
                 
                $model->setId($this->getRequest()->getParam('attribute_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('eavmgmt was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('attribute_id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $eavmgmtId = $this->getRequest()->getParam('attribute_id');
        if(!is_array($eavmgmtId)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('eavmgmt')->__('Please select tax(es).'));
        } else {
            try {
                $model = Mage::getModel('eavmgmt/eavmgmt');
                foreach ($eavmgmtId as $id) {
                    $model->load($id)->delete();
                }
                
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('eavmgmt')->__('Total of %d record(s) were deleted.', count($eavmgmtId))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
         
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $date = date('Ymd_His'); // Get the current date and time in the desired format
        $fileName = 'attribute_' . $date . '.csv'; // Generate the file name
        // $fileName   = 'attribute_20230526_102002.csv';
        $content    = $this->getLayout()->createBlock('eavmgmt/adminhtml_eavmgmt_grid')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $date = date('Ymd_His'); // Get the current date and time in the desired format
        $fileName = 'attribute_' . $date . '.xml';
        // $fileName   = 'attribute_20230526_102002.xml';
        $content    = $this->getLayout()->createBlock('eavmgmt/adminhtml_eavmgmt_grid')
            ->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    // public function ()
    // {
        
    // }



}