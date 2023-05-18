<?php 

class Ccc_Demo_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        // echo "111";
        echo '<pre>';
        // print_r(get_class_methods("Ccc_demo_IndexController"));
        // print_r(Mage::getModel('demo/demo')); 
        // print_r($this->getLayout()->createBlock('demo/test_demo')); 
        print_r(Mage::helper('demo/demo')); 
        print_r(Mage::helper('demo')); 
    }
  
}