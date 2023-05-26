<?php
 
class Ccc_Salesman_Block_Adminhtml_Salesman extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'salesman';
        $this->_controller = 'adminhtml_salesman';
        $this->_headerText = Mage::helper('salesman')->__('Manage Salesmen');
        $this->_addButtonLabel = Mage::helper('salesman')->__('Add New Salesman');
        parent::__construct();
    }
}