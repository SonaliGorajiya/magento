<?php

class Ccc_Practice_Block_Adminhtml_Six_Renderer_Ordercount extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract		
{	
	function render($row)
	{
		$orderCollection = Mage::getResourceModel('sales/order_collection')
        ->addFieldToFilter('customer_id', $row->getEntityId());
    	$orderCount = $orderCollection->getSize();
		return $orderCount;
	}
}