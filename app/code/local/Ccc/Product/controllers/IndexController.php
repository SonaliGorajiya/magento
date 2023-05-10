<?php 

class Ccc_Product_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        // echo "111";
        echo '<pre>';
        // print_r(get_class_methods("Ccc_product_IndexController"));
        // print_r(Mage::getModel('product/product')); 
        // print_r($this->getLayout()->createBlock('product/test_product')); 
        print_r(Mage::helper('product/product')); 
        print_r(Mage::helper('product')); 
    }
  
}