<?php

class Sonali_Collection_Block_Adminhtml_Collection_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('collection_form',array('legend'=>Mage::helper('collection')->__('Collection Information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('collection')->__('Name'),
            'required' => true,
            'name' => 'collection[name]',
        ));

        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('collection')->__('Upload Banner'),
            'class' => 'required-entry',
            'required' => true,
            //'readonly' => true,
            //'renderer' => 'banner/adminhtml_banner_renderer_image',
            'name' => 'image',
        ));

        $fieldset->addField('description','text', array(
            'label' => Mage::helper('collection')->__('Description'),
            'required' => true,
            'name' => 'collection[description]'
        ));

        if ( Mage::getSingleton('adminhtml/session')->getCollectionData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getCollectionData());
            Mage::getSingleton('adminhtml/session')->setCollectionData(null);
        } elseif ( Mage::registry('collection_edit') ) {
            $form->setValues(Mage::registry('collection_edit')->getData());
        }
        return parent::_prepareForm();


    }

}





    