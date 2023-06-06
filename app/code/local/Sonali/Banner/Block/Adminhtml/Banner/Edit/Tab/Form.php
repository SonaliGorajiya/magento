<?php

class Sonali_Banner_Block_Adminhtml_Banner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('banner_form',array('legend'=>Mage::helper('banner')->__('Banner Information')));

        $fieldset->addField('group_id','select', array(
            'name' => 'group_id',
            'label' => Mage::helper('banner')->__('Group Id'),
            'title' => Mage::helper('banner')->__('Group Id'),
            'required' => true,
            'values' => Mage::getModel('banner/group')->getGroups(),
        ));

        $fieldset->addField('image','image', array(
            'label' => Mage::helper('banner')->__('Image'),
            'required' => true,
            'name' => 'image',
            'class' => 'required-entry'
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('banner')->__('Status'),
            'required' => true,
            'name' => 'banner[status]',
            'options' => array(
                1 => Mage::helper('banner')->__('Active'),
                2 => Mage::helper('banner')->__('Inactive'),
            ),
        ));

        $fieldset->addField('position','text', array(
            'label' => Mage::helper('banner')->__('Position'),
            'required' => true,
            'name' => 'banner[position]'
        ));

        if ( Mage::getSingleton('adminhtml/session')->getBannerData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBannerData());
            Mage::getSingleton('adminhtml/session')->setBannerData(null);
        } 
        elseif ( Mage::registry('banner_edit') ) {
            $form->setValues(Mage::registry('banner_edit')->getData());
        }
        return parent::_prepareForm();


    }

}





    