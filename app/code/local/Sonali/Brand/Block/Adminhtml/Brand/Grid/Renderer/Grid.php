<?php

class Sonali_Brand_Block_Adminhtml_Brand_Grid_Renderer_Grid extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {   
        $filename = $row->image;
        $html = "<img src='http://127.0.0.1/2023/magento/magento-mirror/media/brand/".$filename."' width='80px' height='80px'>";
        return $html;

    }

   
}