<?php

class Sonali_Brand_Block_Adminhtml_Brand_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('brand')->__('Brand Information'));
    }
    
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('brand')->__('Brand'),
            'title' => Mage::helper('brand')->__('Brand Information'),
            'content' => $this->getLayout()->createBlock('brand/adminhtml_brand_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}





    