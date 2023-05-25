<?php

class Sonali_Sonali_Model_Resource_Attribute extends Mage_Eav_Model_Resource_Entity_Attribute
{
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {   
        $this->_clearUselessAttributeValues($object);
        return parent::_afterSave($object);
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        $applyTo = $object->getApplyTo();
        if (is_array($applyTo)) {
            $object->setApplyTo(implode(',', $applyTo));
        }
        return parent::_beforeSave($object);
    }

    protected function _clearUselessAttributeValues(Mage_Core_Model_Abstract $object)
    {
        $origData = $object->getOrigData();
        if ($object->isScopeGlobal()
            && isset($origData['is_global'])
            && Sonali_Sonali_Model_Resource_Eav_Attribute::SCOPE_GLOBAL != $origData['is_global']
        ) {
            $attributeStoreIds = array_keys(Mage::app()->getStores());
            if (!empty($attributeStoreIds)) {
                $delCondition = array(
                    'entity_type_id=?' => $object->getEntityTypeId(),
                    'attribute_id = ?' => $object->getId(),
                    'store_id IN(?)'   => $attributeStoreIds,
                );
                $this->_getWriteAdapter()->delete($object->getBackendTable(), $delCondition);
            }
        }
        return $this;
    }
}