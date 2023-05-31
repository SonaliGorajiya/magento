<?php
class Sonali_Idx_Block_Adminhtml_Idx_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('idx_form',array('legend'=>Mage::helper('idx')->__('Upload file')));
        $fieldset->addField('file', 'file', array(
            'label' => Mage::helper('idx')->__('Upload Csv File'),
            'required' => true,
            'name' => 'import_options',
        ));

        // return parent::_prepareForm();
    }
}