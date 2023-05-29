<?php

class Sonali_Eavmgmt_Block_Adminhtml_Eavmgmt_Csv_ShowOption extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract		
{
	
	function render($row)
	{
		if ($row->frontend_input == 'select' || $row->frontend_input == 'multiselect') {
			$a = "<a href='".$this->getUrl('*/*/showOption',['attribute_id'=>$row->getId()])."'>Show Option</a>";
		}
		return $a;
	}
}
