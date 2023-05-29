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

		// echo "<pre>";
		// $id = $row->getAttributeId();
		// $resource = Mage::getSingleton('core/resource');
		// $readConnection = $resource->getConnection('core_read');

		// $tableName = $resource->getTableName('eav_attribute_option');
		// $select = $readConnection->select()->from($tableName, array('option_id', 'attribute_id'));

		// $attributeId = $readConnection->fetchPairs($select);

		// $optionId =  $attributeId[$id];
		// print_r($pairs);
		// echo $optionId;

		// $tableName = $resource->getTableName('eav_attribute_option_value');
		// $select = $readConnection->select()->from($tableName, array('option_id', 'value'));


		// $pairs = $readConnection->fetchPairs($select);

		// $pairs = array_combine($attributeId,$pairs);
		// print_r($pairs);
		// // die;
		// return $pairs[$optionId];
	}
}