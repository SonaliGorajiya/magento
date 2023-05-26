<?php

class Ccc_Demo_Block_Adminhtml_Demo_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()

    {
        parent::__construct();
        $this->_objectId = 'demo_id';
        $this->_blockGroup = 'demo';
        $this->_controller = 'adminhtml_demo';

        $this->_updateButton('save', 'label', Mage::helper('demo')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('demo')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
        'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
        'onclick' => 'saveAndContinueEdit()',
        'class' => 'save',
        ), -100);
    }

    public function getHeaderText()
    {
        return Mage::helper('demo')->__('Edit demo');
    }

}
