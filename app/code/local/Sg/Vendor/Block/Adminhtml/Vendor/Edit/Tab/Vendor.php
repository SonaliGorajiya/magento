<?php

class Sg_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Vendor extends Mage_Adminhtml_Block_Widget_Form
{
   protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('vendor_form',array('legend'=>Mage::helper('vendor')->__('Vendor Information')));
        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('vendor')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'vendor[name]',
        ));

        $fieldset->addField('email', 'text', array(
            'label' => Mage::helper('vendor')->__('Email'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'vendor[email]',
        ));

        $fieldset->addField('password', 'password', array(
            'label' => Mage::helper('vendor')->__('Password'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'vendor[password]',
        ));

        $fieldset->addField('mobile', 'text', array(
            'label' => Mage::helper('vendor')->__('Mobile'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'vendor[mobile]',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('vendor')->__('Status'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'vendor[status]',
            'options' => array(
                '1' => Mage::helper('vendor')->__('Active'),
                '2' => Mage::helper('vendor')->__('Inactive'),
            ),
        ));

        if ( Mage::getSingleton('adminhtml/session')->getvendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getvendorData());
            Mage::getSingleton('adminhtml/session')->setvendorData(null);
        } elseif ( Mage::registry('vendor_data') ) {
            $form->setValues(Mage::registry('vendor_data')->getData());
        }return parent::_prepareForm();
    }
}
