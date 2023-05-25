<?php
class Sonali_Sonali_Model_Sonali extends Mage_Core_Model_Abstract
{
	protected $_attributes;
	const ENTITY = 'sonali';

	public function _construct()
	{
		parent::_construct();
        $this->_init('sonali/sonali');
	}

    public function checkInGroup($attributeId, $setId, $groupId)
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $query = ' SELECT * FROM ' . $resource->getTableName('eav/entity_attribute')
            . ' WHERE `attribute_id` =' . $attributeId
            . ' AND `attribute_group_id` =' . $groupId
            . ' AND `attribute_set_id` =' . $setId ;

        $results = $readConnection->fetchRow($query);
        if ($results) {
            return true;
        }
        return false;
    }
}