<?php

/**
 * 
 */
class Ccc_Practice_Block_Adminhtml_Seven_Renderer_Ordercount extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract		
{
	
	public function render(Varien_Object $row)
    {
        $orderId = $row->getOrderId();
        $order = Mage::getModel('sales/order')->load($orderId);
        $totalProducts = 0;
        foreach ($order->getAllItems() as $item) {
            $totalProducts += $item->getQtyOrdered();
        }

        return $totalProducts;
    }
}