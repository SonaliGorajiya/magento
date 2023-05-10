<?php

class Ccc_Vendor_Block_Adminhtml_Vendor_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('vendor')->__('Vendor Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('vendor_section', array(
        'label' => Mage::helper('vendor')->__('Vendor Information'),
        'title' => Mage::helper('vendor')->__('Vendor Information'),
        'content' => $this->getLayout()->createBlock('vendor/adminhtml_vendor_edit_tab_vendor')->toHtml(),
        ));

        $this->addTab('address_section', array(
        'label' => Mage::helper('vendor')->__('Vendor Address Information'),
        'title' => Mage::helper('vendor')->__('Vendor Address Information'),
        'content' => $this->getLayout()->createBlock('vendor/adminhtml_vendor_edit_tab_address')->toHtml(),
        ));
        return parent::_beforeToHtml();
    }
}
