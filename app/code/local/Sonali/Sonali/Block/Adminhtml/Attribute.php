<?php
class Sonali_Sonali_Block_Adminhtml_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_attribute';
        $this->_blockGroup = 'sonali';
        $this->_headerText = Mage::helper('sonali')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('sonali')->__('Add New Attribute');
        parent::__construct();
    }

}
