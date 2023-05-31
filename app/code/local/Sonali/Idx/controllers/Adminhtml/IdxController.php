<?php
class Sonali_Idx_Adminhtml_IdxController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Idx'))
             ->_title($this->__('Import Product Idxs'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('idx/adminhtml_idx'));
        $this->renderLayout();
    }

    public function editAction() {
        $id = $this->getRequest()->getParam('index');
            $this->loadLayout();
            $this->_setActiveMenu('idx/items');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
            $this->_addContent($this->getLayout()->createBlock(' idx/adminhtml_idx_edit'))
                ->_addLeft($this->getLayout()
                ->createBlock('idx/adminhtml_idx_edit_tabs'));
            $this->renderLayout();
    }

    public function importAction()
    {
        $csvFile = $_FILES['import_options']['tmp_name'];
        $csvData = file_get_contents($csvFile);
        $csvData = array();

        if (($handle = fopen($csvFile, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                $row = array();
                foreach ($data as $value) {
                    $row[] = $value;
                }
                $csvData[] = $row;
            }
              fclose($handle);
        }

        $header = [];
        $idxModel = Mage::getModel('idx/idx');
        foreach ($csvData as $value)
        {
            if(!$header)
            {
                $header = $value;
            }
            else
            {
                $data = array_combine($header,$value);
                $idxModel->insertOnDuplicate($data, array_keys($data));
            }
        }
        
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('idx')->__('Data Imported successfully.'));
        $this->_redirect('*/adminhtml_idx/index'); 
    }

    public function brandAction()
    {
        try {
            Mage::getModel('idx/idx')->updateTableColumn(Mage::getModel('brand/brand'), 'brand');
            Mage::getSingleton('adminhtml/session')->addSuccess('Brand is up to date');
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/index');
    }

    public function collectionAction()
    {
        try {
            Mage::getModel('idx/idx')->updateTableColumn(Mage::getModel('collection/collection'), 'collection');
            Mage::getSingleton('adminhtml/session')->addSuccess('Collection is up to date');
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        try { 
            $idxIds = $this->getRequest()->getParam('index');
            if(!is_array($idxIds)) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('idx')->__('Please select idx(s).'));
            } else {
                $model = Mage::getModel('idx/idx');
                foreach ($idxIds as $idxId) {
                    $model->load($idxId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('idx/idx')->__(
                    'Total of %d record(s) were deleted.', count($idxIds)
                )
                );
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('*/*/index');
    }
}