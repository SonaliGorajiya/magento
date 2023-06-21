<?php
class Ccc_Practice_Class_NineController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
        // Check all methods available in our row class and find out how it works in Magento ?
         echo "<pre>";
       // $adapter = Mage::getSingleton('product/model_product');
       $adapter = new Ccc_Product_Model_Product();
       print_r(get_class_methods($adapter));
        die;
    }

}