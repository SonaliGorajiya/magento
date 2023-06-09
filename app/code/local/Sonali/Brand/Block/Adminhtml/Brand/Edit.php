<?php
class Sonali_Brand_Block_Adminhtml_Brand_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'brand';
        $this->_controller = 'adminhtml_brand';
        $this->_headerText = Mage::helper('brand')->__('Edit Container');
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('brand')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('brand')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
        'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
        'onclick' => 'saveAndContinueEdit()',
        'class' => 'save',
        ), -100);
    }

    public function getHeaderText()
    {
        return Mage::helper('brand')->__('My Form Container');
    }
}