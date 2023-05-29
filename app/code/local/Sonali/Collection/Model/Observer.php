<?php

class Sonali_Collection_Model_Observer
{
    public function prepareCatalogForm($observer)
    {
        $form = $observer->getEvent()->getForm();
        $fieldset = $form->addFieldset('group_fields' . 4, array(
            'legend' => Mage::helper('catalog')->__('General'),
            'class' => 'fieldset-wide'
        ));
        $collection = Mage::getModel('collection/collection')->getCollection()->getItems();
        foreach($collection as $c){
            $options[$c->collection_id] = $c->name ; 
        }
        $fieldset->addField('collection_id', 'select', array(
        'label' => Mage::helper('collection')->__('Collection'),
        'required' => false,
        'name' => 'collection_id',
        'values'=> $options,
        ));
    }
}
