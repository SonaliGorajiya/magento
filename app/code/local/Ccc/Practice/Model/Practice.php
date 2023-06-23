<?php

class Ccc_Practice_Model_Practice extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('practice/practice');
    }

    public function getAttributeArrayWithOption()
    {
        $attributes = Mage::getModel('eav/entity_attribute')->getCollection();
        $attributes->addFieldToFilter('is_user_defined', 1 );
        // $attributes->addFieldToFilter('frontend_input', array('select','multiselect') );

        $readConnection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $optionsTable = Mage::getSingleton('core/resource')->getTableName('eav_attribute_option');
        $optionsValueTable = Mage::getSingleton('core/resource')->getTableName('eav_attribute_option_value');

        foreach ($attributes as $attribute) {
                if ($attribute->getSourceModel()) {
                    $options = $attribute->getSource()->getAllOptions(false);
                    foreach ($options as $option) {
                        $data[] = array(
                            'attribute_id'=>$attribute->getId(),
                            'attribute_code'=>$attribute->getAttributeCode(),
                            'option_id'=>$option['value'],
                            'option_name'=>$option['label'],
                        );
                    }
                } else {
                    $query = $readConnection->select()
                        ->from(array('ao' => $optionsTable), array('option_id', 'sort_order'))
                        ->joinLeft(array('aov' => $optionsValueTable), 'aov.option_id = ao.option_id', array('value'))
                        ->where('ao.attribute_id = ?', $attribute->getId())
                        ->order('ao.sort_order ASC');
                    $options = $readConnection->fetchAll($query);
                    foreach ($options as $option) {
                        $data[] = array(
                                'attribute_id'=>$attribute->getId(),
                                'attribute_code'=>$attribute->getAttributeCode(),
                                'option_id'=>$option['option_id'],
                                'option_name'=>$option['value'],
                        );
                    }
                }
        }
        return $data;
    }

    public function getAttributeArrayWithOptionCount()
    {
        $attributes = Mage::getModel('eav/entity_attribute')->getCollection();
        $attributes->addFieldToFilter('is_user_defined', 1 );
        $attributes->addFieldToFilter('frontend_input', array('select','multiselect') );

        $readConnection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $optionsTable = Mage::getSingleton('core/resource')->getTableName('eav_attribute_option');
        $optionsValueTable = Mage::getSingleton('core/resource')->getTableName('eav_attribute_option_value');

        foreach ($attributes as $attribute) {
                if ($attribute->getSourceModel()) {
                    $options = $attribute->getSource()->getAllOptions(false);
                    $optionCount = 0;
                    foreach ($options as $option) {
                        $optionCount += 1;
                    }
                    $data[] = array(
                        'attribute_id'=>$attribute->getId(),
                        'attribute_code'=>$attribute->getAttributeCode(),
                        'option_count'=>$optionCount,
                    );
                } else {
                    $query = $readConnection->select()
                        ->from(array('ao' => $optionsTable), array('option_id', 'sort_order'))
                        ->joinLeft(array('aov' => $optionsValueTable), 'aov.option_id = ao.option_id', array('value'))
                        ->where('ao.attribute_id = ?', $attribute->getId())
                        ->order('ao.sort_order ASC');
                    $options = $readConnection->fetchAll($query);
                    foreach ($options as $option) {
                        $optionCount += 1;
                    }
                    $data[] = array(
                        'attribute_id'=>$attribute->getId(),
                        'attribute_code'=>$attribute->getAttributeCode(),
                        'option_count'=>$optionCount,
                    );
                }
        }
        return $data;
    }
    
}