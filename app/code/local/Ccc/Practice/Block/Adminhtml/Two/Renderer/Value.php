<?php

/**
 * 
 */
class Ccc_Practice_Block_Adminhtml_Two_renderer_Value extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract		
{
	
	function render($row)
	{
		$id = $row->getOptionId();
		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');

		$tableName = $resource->getTableName('eav_attribute_option_value');
		$select = $readConnection->select()->from($tableName, array('option_id', 'value'));

		$pairs = $readConnection->fetchPairs($select);
		return $pairs[$id];
	}
}