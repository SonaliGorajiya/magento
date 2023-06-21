<?php

class Ccc_Practice_Block_Adminhtml_Ten_Renderer_Value extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract	
{
	public function render(Varien_Object $row)
    {
        $attributeId = $row->getAttributeId();
        $optionId = $row->getValue();

        $attribute = Mage::getModel('eav/entity_attribute')->load($attributeId);
        if ($attribute && $attribute->getSourceModel()){
            if ($attribute && $attribute->usesSource()) {
                $optionText = $attribute->getSource()->getOptionText($optionId);
                if ($optionText) {
                    return $optionText;
                } 
            } 
        }
        elseif($row->attribute_code == "cost"){
            return $row->getValue();
        }

        $resource = Mage::getSingleton('core/resource');
        $read = $resource->getConnection('core_read');
        $sql = $read->select()->from('eav_attribute_option_value', 'value')
            ->where('option_id =?', $row->value);
        return $read->fetchOne($sql);
    }
}