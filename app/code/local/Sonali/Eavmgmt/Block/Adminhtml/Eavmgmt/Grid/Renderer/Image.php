<?php

class Sonali_Eavmgmt_Block_Adminhtml_eavmgmt_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract		
{
	function render($row)
	{
		$name = $row->getImage();
		$path = "<img src='http://127.0.0.1/2023/magento/magento-mirror/media/eavmgmt/{$name}' alt='img' width='50' height='60'>";
		return $path;
	}
}