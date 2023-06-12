<?php

class Ccc_Category_Block_Adminhtml_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'category_id';
        $this->_blockGroup = 'category';
        $this->_controller = 'adminhtml_category';

        $this->_updateButton('save', 'label', Mage::helper('category')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('category')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
        'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
        'onclick' => 'saveAndContinueEdit()',
        'class' => 'save',
        ), -100);
    }

    public function getHeaderText()
    {
        return Mage::helper('category')->__('Edit category');
    }

}

