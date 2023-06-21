<?php
class Ccc_Practice_Class_EightController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
       
        echo "<pre>";
        // 8. Check all methods available in our resource class and find out how it works in Magento ?

       $productResource = Mage::getSingleton('product/resource_product');
       print_r(get_class_methods($productResource));
        die;

    }

}