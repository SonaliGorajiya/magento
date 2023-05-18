<?php

class Sonali_Sonali_Block_Adminhtml_Sonali_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()

    {
        parent::__construct();
        $this->_objectId = 'sonali_id';
        $this->_blockGroup = 'sonali';
        $this->_controller = 'adminhtml_sonali';

        $this->_updateButton('save', 'label', Mage::helper('sonali')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('sonali')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
        'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
        'onclick' => 'saveAndContinueEdit()',
        'class' => 'save',
        ), -100);
    }

    public function getHeaderText()
    {
        return Mage::helper('sonali')->__('Edit Data');
    }

}
