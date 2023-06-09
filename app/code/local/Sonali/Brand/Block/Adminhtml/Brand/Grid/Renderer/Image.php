<?php
class Sonali_Brand_Block_Adminhtml_Brand_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $imageUrl = Mage::getBaseUrl('media') . 'Brand' . DS . $row->getData('image');
        $imageHtml = '<img src="' . $imageUrl . '" width="50" height="50" alt="Image" />';
        return $imageHtml;
    }
}