<?php 

class Sonali_Brand_Block_Adminhtml_Brand_Grid_Renderer_Banner extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $name = $row->getBannerImage();
        $imageUrl = Mage::getBaseUrl('media').DS.$name;
        $path = "<img src='$imageUrl' alt='img' width='120' height='70'>";
        return $path;
    }
}
