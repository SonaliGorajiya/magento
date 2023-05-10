<?php 

class Ccc_Salesman_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        // echo "111";
        echo '<pre>';
        print_r(get_class_methods($this->getLayout()));
        // print_r(get_class_methods("Ccc_Vendor_IndexController"));
        // print_r(Mage::getModel('vendor/vendor')); 
        // print_r($this->getLayout()->createBlock('vendor/test_vendor')); 
        print_r(Mage::helper('salesman/salesman')); 
        print_r(Mage::helper('salesman')); 
    }
  
}