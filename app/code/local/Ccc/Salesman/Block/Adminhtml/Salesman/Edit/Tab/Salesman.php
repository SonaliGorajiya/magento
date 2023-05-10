<?php

class Ccc_Salesman_Block_Adminhtml_Salesman_Edit_Tab_Salesman extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('salesman_data');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('salesman_form',array('legend'=>Mage::helper('salesman')->__('Salesman information')));

        $fieldset->addField('first_name', 'text', array(
            'name'      => 'salesman[first_name]',
            'label'     => Mage::helper('salesman')->__('First Name'),
            'required'  => true,
        ));

        $fieldset->addField('last_name', 'text', array(
            'name'      => 'salesman[last_name]',
            'label'     => Mage::helper('salesman')->__('Last Name'),
            'required'  => true,
        ));

        $fieldset->addField('email', 'text', array(
            'name'      => 'salesman[email]',
            'label'     => Mage::helper('salesman')->__('Email'),
            'required'  => true,
        ));

        $fieldset->addField('gender', 'radios', array(
            'label' => Mage::helper('salesman')->__('Gender'),
            'name'      => 'salesman[gender]',
            'values' => array(
            array('value'=>'1','label'=>'Male'),
            array('value'=>'2','label'=>'Female')),
        ));

        $fieldset->addField('mobile', 'text', array(
            'name'      => 'salesman[mobile]',
            'label'     => Mage::helper('salesman')->__('Mobile'),
            'required'  => true,
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('salesman')->__('Status'),
            'title'     => Mage::helper('salesman')->__('Status'),
            'name'      => 'salesman[status]',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('salesman')->__('Active'),
                '2' => Mage::helper('salesman')->__('Inactive'),
            ),
        ));

        $fieldset->addField('company', 'text', array(
            'name'      => 'salesman[company]',
            'label'     => Mage::helper('salesman')->__('Company'),
            'required'  => true,
        ));

        $this->setForm($form);
        $form->setValues($model->getData());

        return parent::_prepareForm();
    }
}
