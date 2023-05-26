<?php
 
class Ccc_Demo_Block_Adminhtml_Demo extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'demo';
        $this->_controller = 'adminhtml_demo';
        $this->_headerText = Mage::helper('demo')->__('Manage Demos');
        $this->_addButtonLabel = Mage::helper('demo')->__('Add New Demo');
        parent::__construct();
    }
}