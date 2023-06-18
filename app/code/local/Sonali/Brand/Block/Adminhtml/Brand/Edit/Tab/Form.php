<?php

class Sonali_Brand_Block_Adminhtml_Brand_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('brand_form',array('legend'=>Mage::helper('brand')->__('Brand Information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('brand')->__('Name'),
            'required' => true,
            'name' => 'brand[name]',
        ));

        $fieldset->addField('image','image', array(
            'label' => Mage::helper('brand')->__('Image'),
            'required' => true,
            'name' => 'image',
            'class' => 'required-entry'
        ));

         $fieldset->addField('banner', 'file', array(
            'label' => Mage::helper('brand')->__('Banner'),
            'required' => false,
            'name' => 'banner',
        ));

        $fieldset->addField('url_key', 'text', array(
            'label' => Mage::helper('brand')->__('Url Key'),
            'required' => true,
            'name' => 'brand[url_key]',
        ));

        $fieldset->addField('sort_order', 'text', array(
            'label' => Mage::helper('brand')->__('Sort Order'),
            'required' => false,
            'name' => 'brand[sort_order]',
        ));

        $fieldset->addField('status','select', array(
            'label' => Mage::helper('brand')->__('Status'),
            'required' => false,
            'name' => 'brand[status]',
            'options' => array(1=>'Active',2=>'Inactive')
        ));

        $fieldset->addField('description','text', array(
            'label' => Mage::helper('brand')->__('Description'),
            'required' => true,
            'name' => 'brand[description]'
        ));

        if ( Mage::getSingleton('adminhtml/session')->getBrandData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBrandData());
            Mage::getSingleton('adminhtml/session')->setBrandData(null);
        } 
        elseif ( Mage::registry('brand_edit') ) {
            $form->setValues(Mage::registry('brand_edit')->getData());
        }
        return parent::_prepareForm();
    }

}





    