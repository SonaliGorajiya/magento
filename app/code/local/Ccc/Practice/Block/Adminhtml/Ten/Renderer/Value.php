<?php

class Ccc_Practice_Block_Adminhtml_Ten_Renderer_Value extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract	
{
	function render($row)
    {
        if ($row->attribute_code == "brand") {
            return Mage::getModel("brand/brand")->load($row->getValue())->getName();
        }if ($row->attribute_code == "cost") {
            return $row->getValue();
        }
        $resource = Mage::getSingleton('core/resource');
        $read = $resource->getConnection('core_read');
        $sql = $read->select()->from('eav_attribute_option_value', 'value')->where('option_id = ?', $row->getValue());
        return $read->fetchOne($sql);
    }
}