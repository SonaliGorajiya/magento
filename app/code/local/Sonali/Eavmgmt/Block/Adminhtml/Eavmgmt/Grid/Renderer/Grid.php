<?php

class Sonali_Eavmgmt_Block_Adminhtml_Eavmgmt_Grid_Renderer_Grid extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        return $row->entity_type_code;
    }
   
}