<?php

class Sg_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Vendor extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('vendor_data');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('vendor_form',array('legend'=>Mage::helper('vendor')->__('Vendor information')));

        $fieldset->addField('first_name', 'text', array(
            'name'      => 'vendor[first_name]',
            'label'     => Mage::helper('vendor')->__('First Name'),
            'required'  => true,
        ));

        $fieldset->addField('last_name', 'text', array(
            'name'      => 'vendor[last_name]',
            'label'     => Mage::helper('vendor')->__('Last Name'),
            'required'  => true,
        ));

        $fieldset->addField('email', 'text', array(
            'name'      => 'vendor[email]',
            'label'     => Mage::helper('vendor')->__('Email'),
            'required'  => true,
        ));

        $fieldset->addField('gender', 'select', array(
            'label'     => Mage::helper('vendor')->__('Gender'),
            'title'     => Mage::helper('vendor')->__('Gender'),
            'name'      => 'vendor[gender]',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('vendor')->__('Male'),
                '2' => Mage::helper('vendor')->__('Female'),
            ),
        ));

        $fieldset->addField('mobile', 'text', array(
            'name'      => 'vendor[mobile]',
            'label'     => Mage::helper('vendor')->__('Mobile'),
            'required'  => true,
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('vendor')->__('Status'),
            'title'     => Mage::helper('vendor')->__('Status'),
            'name'      => 'vendor[status]',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('vendor')->__('Active'),
                '2' => Mage::helper('vendor')->__('Inactive'),
            ),
        ));

        $fieldset->addField('company', 'text', array(
            'name'      => 'vendor[company]',
            'label'     => Mage::helper('vendor')->__('Company'),
            'required'  => true,
        ));

        $this->setForm($form);
        $form->setValues($model->getData());

        return parent::_prepareForm();
    }
}
