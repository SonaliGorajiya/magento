<?php

class Ccc_Practice_Block_Adminhtml_Six_Renderer_Name extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract	
{
	function render($row)
	{
		return $row->getName();
	}
}