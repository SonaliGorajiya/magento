<?php
class Sonali_Banner_Block_Adminhtml_Group_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('group_form',array('legend'=>Mage::helper('banner')->__('Banner Group Information')));
        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('banner')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'group[name]',
        ));

        $fieldset->addField('group_key', 'text', array(
            'label' => Mage::helper('banner')->__('Group Key'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'group[group_key]',
        ));

        $fieldset->addField('height', 'text', array(
            'label' => Mage::helper('banner')->__('Height'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'group[height]',
        ));

        $fieldset->addField('width', 'text', array(
            'label' => Mage::helper('banner')->__('Width'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'group[width]',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getbanner_groupData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getbanner_groupData());
            Mage::getSingleton('adminhtml/session')->setbanner_groupData(null);
        } elseif ( Mage::registry('group_data') ) {
            $form->setValues(Mage::registry('group_data')->getData());
        }

        return parent::_prepareForm();
    }
}