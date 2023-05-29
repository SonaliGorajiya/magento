<?php

class Sonali_Brand_Block_Adminhtml_Brand_Edit_Tab_Brand extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('brand_data');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('brand_form',array('legend'=>Mage::helper('brand')->__('Brand information')));

        $fieldset->addField('name', 'text', array(
            'name'      => 'brand[name]',
            'label'     => Mage::helper('brand')->__('Name'),
            'required'  => true,
        ));

        $fieldset->addField('image', 'file', array(
            'name'      => 'image',
            'label'     => Mage::helper('brand')->__('Image'),
            'required'  => true,
        ));

        $fieldset->addField('description', 'text', array(
            'name'      => 'brand[description]',
            'label'     => Mage::helper('brand')->__('Description'),
            'required'  => true,
        ));

        $this->setForm($form);
        $form->setValues($model->getData());

        return parent::_prepareForm();
    }
}
