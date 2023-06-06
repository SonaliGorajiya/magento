<?php

class Sonali_Banner_Block_Adminhtml_Banner_Group_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('banner_form',array('legend'=>Mage::helper('banner')->__('banner information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('banner')->__('Name'),
            'required' => true,
            'name' => 'group[name]',
        ));

        $fieldset->addField('group_key', 'text', array(
            'label' => Mage::helper('banner')->__('Group Key'),
            'required' => true,
            'name' => 'group[group_key]',
        ));

        $fieldset->addField('height', 'text', array(
            'label' => Mage::helper('banner')->__('Height'),
            'required' => true,
            'name' => 'group[height]'
        ));

        $fieldset->addField('width', 'text', array(
            'label' => Mage::helper('banner')->__('Width'),
            'required' => true,
            'name' => 'group[width]'
        ));

        if ( Mage::getSingleton('adminhtml/session')->getBrandData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBrandData());
            Mage::getSingleton('adminhtml/session')->setBrandData(null);
        } elseif ( Mage::registry('banner_edit') ) {
            $form->setValues(Mage::registry('banner_edit')->getData());
        }
        return parent::_prepareForm();


    }

}





    