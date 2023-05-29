<?php
class Sonali_Eavmgmt_Block_Adminhtml_Eavmgmt_Edit_Tab_Eavmgmt extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('current_eavmgmt');

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('eavmgmt_form', array('legend'=>Mage::helper('eavmgmt')->__('Eavmgmt information')));

        $fieldset->addField('first_name', 'text', array(
            'label' => Mage::helper('eavmgmt')->__('First Name'),
            'required' => true,
            'name' => 'eavmgmt[first_name]',
        ));

        $fieldset->addField('last_name', 'text', array(
            'label' => Mage::helper('eavmgmt')->__('Last Name'),
            'required' => true,
            'name' => 'eavmgmt[last_name]',
        ));

        $fieldset->addField('email', 'text', array(
            'label' => Mage::helper('eavmgmt')->__('Email'),
            'required' => true,
            'name' => 'eavmgmt[email]',
        ));

        $fieldset->addField('gender', 'select', array(
            'label' => Mage::helper('eavmgmt')->__('Gender'),
            'required' => true,
            'name' => 'eavmgmt[gender]',
            'options'=> array(
                '1'=>Mage::helper('eavmgmt')->__('Male'),
                '2'=>Mage::helper('eavmgmt')->__('Female'),
            ),
        ));

        $fieldset->addField('mobile', 'text', array(
            'label' => Mage::helper('eavmgmt')->__('Mobile'),
            'required' => true,
            'name' => 'eavmgmt[mobile]',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('eavmgmt')->__('Status'),
            'required' => true,
            'name' => 'eavmgmt[status]',
            'options'=> array(
                '1'=>Mage::helper('eavmgmt')->__('Active'),
                '2'=>Mage::helper('eavmgmt')->__('Inactive'),
            ),
        ));

        $fieldset->addField('company', 'text', array(
            'label' => Mage::helper('eavmgmt')->__('Company'),
            'required' => true,
            'name' => 'eavmgmt[company]',
        ));

       
        
        // if ( Mage::getSingleton('adminhtml/session')->geteavmgmtData() )
        // {
        //     $form->setValues(Mage::getSingleton('adminhtml/session')->geteavmgmtData());
        //     Mage::getSingleton('adminhtml/session')->seteavmgmtData(null);
        // } elseif ( Mage::registry('current_eavmgmt') ) {
        //     $form->setValues(Mage::registry('current_eavmgmt')->getData());
        // }
        $form->setValues($model->getData());
        return parent::_prepareForm();
        }
}