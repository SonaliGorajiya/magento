<?php

class Ccc_Product_Block_Adminhtml_Product_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('product_data');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('product_form',array('legend'=>Mage::helper('product')->__('Product information')));

        $fieldset->addField('name', 'text', array(
            'name'      => 'product[name]',
            'label'     => Mage::helper('product')->__('Name'),
            'required'  => true,
        ));

        $fieldset->addField('sku', 'text', array(
            'name'      => 'product[sku]',
            'label'     => Mage::helper('product')->__('Sku'),
            'required'  => true,
        ));

        $fieldset->addField('cost', 'text', array(
            'name'      => 'product[cost]',
            'label'     => Mage::helper('product')->__('Cost'),
            'required'  => true,
        ));

        $fieldset->addField('price', 'text', array(
            'name'      => 'product[price]',
            'label'     => Mage::helper('product')->__('Price'),
            'required'  => true,
        ));

        $fieldset->addField('quantity', 'text', array(
            'name'      => 'product[quantity]',
            'label'     => Mage::helper('product')->__('Quantity'),
            'required'  => true,
        ));

        $fieldset->addField('description', 'text', array(
            'name'      => 'product[description]',
            'label'     => Mage::helper('product')->__('Description'),
            'required'  => true,
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('product')->__('Status'),
            'title'     => Mage::helper('product')->__('Status'),
            'name'      => 'product[status]',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('product')->__('Active'),
                '2' => Mage::helper('product')->__('Inactive'),
            ),
        ));

        $fieldset->addField('color', 'select', array(
            'label'     => Mage::helper('product')->__('Color'),
            'title'     => Mage::helper('product')->__('Color'),
            'name'      => 'product[color]',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('product')->__('Color1'),
                '2' => Mage::helper('product')->__('Color2'),
            ),
        ));

        $fieldset->addField('material', 'select', array(
            'label'     => Mage::helper('product')->__('Material'),
            'title'     => Mage::helper('product')->__('Material'),
            'name'      => 'product[material]',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('product')->__('Material1'),
                '2' => Mage::helper('product')->__('Material2'),
            ),
        ));

        $this->setForm($form);
        $form->setValues($model->getData());

        return parent::_prepareForm();
    }
}
