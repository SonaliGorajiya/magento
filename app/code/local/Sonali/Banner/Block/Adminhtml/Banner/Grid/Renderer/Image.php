<?php 

class Sonali_Banner_Block_Adminhtml_Banner_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $name = $row->getImage();
        $imageUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$name;
        $path = "<img src='{$imageUrl}' width='70' height='80'>";

        return $path;
    }
}
