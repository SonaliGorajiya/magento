<?php

class Ccc_Salesman_Block_Adminhtml_Salesman_Edit_Tab_Address extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('salesman_address_data');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('salesman_address_form',array('legend'=>Mage::helper('salesman')->__('Salesman Address information')));

        $fieldset->addField('address', 'text', array(
            'name'      => 'address[address]',
            'label'     => Mage::helper('salesman')->__('Address'),
            'required'  => true,
        ));

        $fieldset->addField('city', 'text', array(
            'name'      => 'address[city]',
            'label'     => Mage::helper('salesman')->__('City'),
            'required'  => true,
        ));

        $fieldset->addField('state', 'text', array(
            'name'      => 'address[state]',
            'label'     => Mage::helper('salesman')->__('State'),
            'required'  => true,
        ));

        $fieldset->addField('country', 'text', array(
            'name'      => 'address[country]',
            'label'     => Mage::helper('salesman')->__('Country'),
            'required'  => true,
        ));

        $fieldset->addField('zip_code', 'text', array(
            'name'      => 'address[zip_code]',
            'label'     => Mage::helper('salesman')->__('zip code'),
            'required'  => true,
        ));

       

        $this->setForm($form);
        $form->setValues($model->getData());

        return parent::_prepareForm();
    }
}
