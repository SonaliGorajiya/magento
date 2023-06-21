<?php

/**
 * 
 */
class Ccc_Practice_Block_Adminhtml_Seven_Renderer_Name extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract		
{
	
	public function render(Varien_Object $row)
    {
        $customerId = $row->getCustomerId();
        $customer = Mage::getModel('customer/customer')->load($customerId);

        $customerName = $customer->getFirstname() . ' ' . $customer->getLastname();

        return $customerName;
    }
}