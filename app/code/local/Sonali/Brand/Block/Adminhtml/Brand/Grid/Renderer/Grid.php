<?php

class Sonali_Brand_Block_Adminhtml_Brand_Grid_Renderer_Grid extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {   
        $filename = Mage::getBaseUrl('media') . 'Brand' . DS . $row->getData('image');
        $html = '<img src="' . $filename . '" width="70" height="70" alt="Image" />';
        return $html;

    }

   
}