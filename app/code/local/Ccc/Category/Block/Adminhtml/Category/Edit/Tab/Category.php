<?php

class Ccc_Category_Block_Adminhtml_Category_Edit_Tab_Category extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('category_data');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('category_form',array('legend'=>Mage::helper('category')->__('Category information')));
        
        $fieldset->addField('parent_id', 'text', array(
            'name'      => 'category[parent_id]',
            'label'     => Mage::helper('category')->__('Parent Id'),
            'required'  => true,
        ));


        $fieldset->addField('path', 'text', array(
            'name'      => 'category[path]',
            'label'     => Mage::helper('category')->__('Path'),
            'required'  => true,
        ));

        $fieldset->addField('name', 'text', array(
            'name'      => 'category[name]',
            'label'     => Mage::helper('category')->__('Name'),
            'required'  => true,
        ));


        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('category')->__('Status'),
            'title'     => Mage::helper('category')->__('Status'),
            'name'      => 'category[status]',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('category')->__('Active'),
                '2' => Mage::helper('category')->__('Inactive'),
            ),
        ));
        
        $fieldset->addField('description', 'text', array(
            'name'      => 'category[description]',
            'label'     => Mage::helper('category')->__('Description'),
            'required'  => true,
        ));

        $this->setForm($form);
        $form->setValues($model->getData());

        return parent::_prepareForm();
    }
}
