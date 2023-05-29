<?php

class Sonali_Sonali_Block_Adminhtml_Sonali_Grid_Renderer_Grid extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        if ($row->gender == 3) {
            return 'Male';
        }
        else if ($row->gender == 4) {
            return 'Female';
        }
        else{
            return null;
        }
    }

   
}