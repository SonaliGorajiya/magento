<?php

class Sonali_Eavmgmt_Adminhtml_EavmgmtController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Eavmgmt'))
             ->_title($this->__('Manage Eavmgmts'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('eavmgmt/adminhtml_eavmgmt'));
        $this->renderLayout();
    }

    public function editAction()
    {
        $this->_title($this->__('Attributes'))
             ->_title($this->__('import Options'));
            $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('eavmgmt/adminhtml_eavmgmt_edit'))
                ->_addLeft($this->getLayout()
                ->createBlock('eavmgmt/adminhtml_eavmgmt_edit_tabs'));

        $this->renderLayout();
    }

    public function exportCsvAction()
    {
        print_r($_POST);
        $fileName   ='attribute_'.date('Ymd_His').'.csv';
        $grid       = $this->getLayout()->createBlock('eavmgmt/adminhtml_eavmgmt_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    public function selectedExportAction()
    {
            $attributes = $this->getRequest()->getPost('attribute_id');
            $fileName   ='attribute_'.date('Ymd_His').'.csv';
             $collection = Mage::getResourceModel('eav/entity_attribute_collection');
             $collection->addFieldToFilter('attribute_id', array('in' => $attributes));
            $this->_prepareDownloadResponse($fileName, $content);
            $grid= $this->getLayout()->createBlock('eavmgmt/adminhtml_eavmgmt_csv');
            $grid->setCollection($collection);
            $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
             $this->_redirect('*/*/index');
    }

    public function selectedExportOptionsAction()
    {
            $attributes = $this->getRequest()->getPost('attribute_id');
            $fileName   ='attributeoptions_'.date('Ymd_His').'.csv';
             $collection = Mage::getResourceModel('eav/entity_attribute_option_collection');
             $collection->getSelect()
            ->join(
                array('second_table' => 'eav_attribute'),
                'main_table.attribute_id = second_table.attribute_id',
                array('entity_type_id','frontend_label','attribute_code')
            );
            $collection->addFieldToFilter('main_table.attribute_id', array('in' => $attributes));
            $this->_prepareDownloadResponse($fileName, $content);
            $grid= $this->getLayout()->createBlock('eavmgmt/adminhtml_eavmgmt_exportoption');
            $grid->setCollection($collection);
            $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
             $this->_redirect('*/*/index');
    }

    public function showoptionAction()
    {
       
        $this->_title($this->__('Eavmgmt'))
             // ->_title($this->__('Manage Eavmgmts'))
             ->_title($this->__('Manage Eavmgmts'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('eavmgmt/Adminhtml_eavmgmt_Option'));
        $this->renderLayout();
    }

}
