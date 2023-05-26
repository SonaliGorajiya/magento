<?php

class Sonali_Sonali_Block_Adminhtml_Attribute_Edit_Tab_Front extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $model = Mage::registry('entity_attribute');

        $form = new Varien_Data_Form(array('id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post'));

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('sonali')->__('Frontend Properties')));

        $yesno = array(
            array(
                'value' => 0,
                'label' => Mage::helper('sonali')->__('No')
            ),
            array(
                'value' => 1,
                'label' => Mage::helper('sonali')->__('Yes')
            ));


        $fieldset->addField('is_searchable', 'select', array(
            'name' => 'is_searchable',
            'label' => Mage::helper('sonali')->__('Use in Quick Search'),
            'title' => Mage::helper('sonali')->__('Use in Quick Search'),
            'values' => $yesno,
        ));

        $fieldset->addField('is_visible_in_advanced_search', 'select', array(
            'name' => 'is_visible_in_advanced_search',
            'label' => Mage::helper('sonali')->__('Use in Advanced Search'),
            'title' => Mage::helper('sonali')->__('Use in Advanced Search'),
            'values' => $yesno,
        ));

        $fieldset->addField('is_comparable', 'select', array(
            'name' => 'is_comparable',
            'label' => Mage::helper('sonali')->__('Comparable on the Frontend'),
            'title' => Mage::helper('sonali')->__('Comparable on the Frontend'),
            'values' => $yesno,
        ));


        $fieldset->addField('is_filterable', 'select', array(
            'name' => 'is_filterable',
            'label' => Mage::helper('sonali')->__("Use in Layered Navigation<br/>(Can be used only with sonali input type 'Dropdown')"),
            'title' => Mage::helper('sonali')->__('Can be used only with sonali input type Dropdown'),
            'values' => array(
                array('value' => '0', 'label' => Mage::helper('sonali')->__('No')),
                array('value' => '1', 'label' => Mage::helper('sonali')->__('Filterable (with results)')),
                array('value' => '2', 'label' => Mage::helper('sonali')->__('Filterable (no results)')),
            ),
        ));

//        if ($model->getIsUserDefined() || !$model->getId()) {
            $fieldset->addField('is_visible_on_front', 'select', array(
                'name' => 'is_visible_on_front',
                'label' => Mage::helper('sonali')->__('Visible on sonali Pages on Front-end'),
                'title' => Mage::helper('sonali')->__('Visible on sonali Pages on Front-end'),
                'values' => $yesno,
            ));
//        }

        $form->setValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }

}
