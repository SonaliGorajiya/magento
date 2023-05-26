<?php

class Sonali_Sonali_Block_Adminhtml_Sonali_Edit_Tab_Sonali extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('sonali_data');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('sonali_form',array('legend'=>Mage::helper('sonali')->__('Sonali Information')));

        $fieldset->addField('name', 'text', array(
            'name'      => 'sonali[name]',
            'label'     => Mage::helper('sonali')->__('Name'),
            'required'  => true,
        ));

        /*$fieldset->addField('last_name', 'text', array(
            'name'      => 'sonali[last_name]',
            'label'     => Mage::helper('sonali')->__('Last Name'),
            'required'  => true,
        ));

        $fieldset->addField('email', 'text', array(
            'name'      => 'sonali[email]',
            'label'     => Mage::helper('sonali')->__('Email'),
            'required'  => true,
        ));

        $fieldset->addField('gender', 'select', array(
            'label'     => Mage::helper('sonali')->__('Gender'),
            'title'     => Mage::helper('sonali')->__('Gender'),
            'name'      => 'sonali[gender]',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('sonali')->__('Male'),
                '2' => Mage::helper('sonali')->__('Female'),
            ),
        ));


        $fieldset->addField('mobile', 'text', array(
            'name'      => 'sonali[mobile]',
            'label'     => Mage::helper('sonali')->__('Mobile'),
            'required'  => true,
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('sonali')->__('Status'),
            'title'     => Mage::helper('sonali')->__('Status'),
            'name'      => 'sonali[status]',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('sonali')->__('Active'),
                '2' => Mage::helper('sonali')->__('Inactive'),
            ),
        ));

        $fieldset->addField('company', 'text', array(
            'name'      => 'sonali[company]',
            'label'     => Mage::helper('sonali')->__('Company'),
            'required'  => true,
        ));*/

        $this->setForm($form);
        $form->setValues($model->getData());

        return parent::_prepareForm();
    }
}
