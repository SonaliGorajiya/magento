<?php 

class Sonali_Brand_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        // echo "111";
        echo '<pre>';
        // print_r(get_class_methods("Sonali_brand_IndexController"));
        // print_r(Mage::getModel('brand/brand')); 
        // print_r($this->getLayout()->createBlock('brand/test_brand')); 
        print_r(Mage::helper('brand/brand')); 
        print_r(Mage::helper('brand')); 
    }
  
}