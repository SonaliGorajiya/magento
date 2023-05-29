<?php

class Sonali_Eavmgmt_Block_Adminhtml_Eavmgmt_Import_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('eavmgmt_form',array('legend'=>Mage::helper('eavmgmt')->__('eavmgmt information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('eavmgmt')->__('Name'),
            'required' => true,
            'name' => 'name',
        ));

         $fieldset->addField('image', 'file', array(
            'label' => Mage::helper('eavmgmt')->__('Image'),
            'required' => true,
            'name' => 'image',
        ));

          $fieldset->addField('description', 'text', array(
            'label' => Mage::helper('eavmgmt')->__('Description'),
            'required' => true,
            'name' => 'description',
        ));

        if ( Mage::getSingleton('adminhtml/session')->geteavmgmtData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->geteavmgmtData());
            Mage::getSingleton('adminhtml/session')->seteavmgmtData(null);
        } elseif ( Mage::registry('eavmgmt_edit') ) {
            $form->setValues(Mage::registry('eavmgmt_edit')->getData());
        }
        return parent::_prepareForm();


    }

}





    