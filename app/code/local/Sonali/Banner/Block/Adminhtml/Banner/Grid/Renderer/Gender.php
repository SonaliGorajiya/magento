<?php 

class Sonali_Banner_Block_Adminhtml_Banner_Grid_Renderer_Gender extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $gender = $row->getGender();
        switch ($gender) {
            case '1':
                $label = 'Male';
                break;
            case '2':
                $label = 'Female';
                break;
            case '3':
                $label = 'Other';
                break;
        }
        return $label;
    }
}
