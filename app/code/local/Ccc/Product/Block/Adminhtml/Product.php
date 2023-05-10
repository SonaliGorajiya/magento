<?php
 
class Ccc_Product_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'product';
        $this->_controller = 'adminhtml_product';
        $this->_headerText = Mage::helper('product')->__('Manage Products');
        $this->_addButtonLabel = Mage::helper('product')->__('Add New Product');
        parent::__construct();
    }
}