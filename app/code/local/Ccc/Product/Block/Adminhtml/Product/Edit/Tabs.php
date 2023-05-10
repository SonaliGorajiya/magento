<?php

class Ccc_Product_Block_Adminhtml_Product_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('product')->__('Product Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('product_section', array(
        'label' => Mage::helper('product')->__('Product Information'),
        'title' => Mage::helper('product')->__('Product Information'),
        'content' => $this->getLayout()->createBlock('product/adminhtml_product_edit_tab_product')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
