<?php
 
class Ccc_Practice_Block_Adminhtml_Practice extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'practice';
        $this->_controller = 'adminhtml_practice';
        $this->_headerText = Mage::helper('practice')->__('Manage Practices');
        $this->_addButtonLabel = Mage::helper('practice')->__('Add New practice');
        parent::__construct();
    }
}