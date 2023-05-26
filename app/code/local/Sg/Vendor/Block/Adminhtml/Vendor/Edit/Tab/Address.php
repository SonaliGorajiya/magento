<?php

class Sg_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Address extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('vendor_address_data');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('vendor_address_form',array('legend'=>Mage::helper('vendor')->__('Vendor Address information')));

        $fieldset->addField('address', 'text', array(
            'name'      => 'address[address]',
            'label'     => Mage::helper('vendor')->__('Address'),
            'required'  => true,
        ));

        $fieldset->addField('city', 'text', array(
            'name'      => 'address[city]',
            'label'     => Mage::helper('vendor')->__('City'),
            'required'  => true,
        ));

        $fieldset->addField('state', 'text', array(
            'name'      => 'address[state]',
            'label'     => Mage::helper('vendor')->__('State'),
            'required'  => true,
        ));

        $fieldset->addField('country', 'text', array(
            'name'      => 'address[country]',
            'label'     => Mage::helper('vendor')->__('Country'),
            'required'  => true,
        ));

        $fieldset->addField('zip_code', 'text', array(
            'name'      => 'address[zip_code]',
            'label'     => Mage::helper('vendor')->__('zip code'),
            'required'  => true,
        ));

       

        $this->setForm($form);
        $form->setValues($model->getData());

        return parent::_prepareForm();
    }
}
