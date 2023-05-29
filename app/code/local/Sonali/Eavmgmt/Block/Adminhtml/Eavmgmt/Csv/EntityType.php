<?php

class Sonali_Eavmgmt_Block_Adminhtml_Eavmgmt_Csv_EntityType extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract		
{
	
	function render($row)
	{
		$id = $row->getEntityTypeId();
		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');

		$tableName = $resource->getTableName('eav_entity_type');
		$select = $readConnection->select()->from($tableName, array('entity_type_id', 'entity_type_code'));

		$pairs = $readConnection->fetchPairs($select);
		return $pairs[$id];

	}
}