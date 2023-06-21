<?php

class Ccc_Practice_Block_Adminhtml_One_Renderer_Color extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract	
{
	function render($row)
	{
		$color = $row->getColor();
		$option = Mage::getModel('eav/entity_attribute_option')->load($color);

		$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'color');
        $option = $attribute->getSource()->getOptionText($color);
		return $option;
	}
}