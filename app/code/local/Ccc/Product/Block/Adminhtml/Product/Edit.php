<?php

class Ccc_Product_Block_Adminhtml_Product_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()

    {
        parent::__construct();
        $this->_objectId = 'product_id';
        $this->_blockGroup = 'product';
        $this->_controller = 'adminhtml_product';

        $this->_updateButton('save', 'label', Mage::helper('product')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('product')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
        'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
        'onclick' => 'saveAndContinueEdit()',
        'class' => 'save',
        ), -100);
    }

    public function getHeaderText()
    {
        return Mage::helper('product')->__('Edit product');
    }

}
