<?php

class Sonali_Collection_Block_Adminhtml_Collection_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('collection')->__('Collection Information'));
    }
    
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('collection')->__('Collection'),
            'title' => Mage::helper('collection')->__('Collection Information'),
            'content' => $this->getLayout()->createBlock('collection/adminhtml_collection_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}





    