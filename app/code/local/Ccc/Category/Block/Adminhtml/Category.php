<?php
 
class Ccc_Category_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'category';
        $this->_controller = 'adminhtml_category';
        $this->_headerText = Mage::helper('category')->__('Manage Categories');
        $this->_addButtonLabel = Mage::helper('category')->__('Add New Category');
        parent::__construct();
    }
}