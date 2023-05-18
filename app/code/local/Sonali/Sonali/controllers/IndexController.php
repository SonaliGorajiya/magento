<?php 

class Sonali_Sonali_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        // echo "111";
        echo '<pre>';
        print_r(get_class_methods($this->getLayout()));
        // print_r(get_class_methods("Sonali_Sonali_IndexController"));
        // print_r(Mage::getModel('sonali/sonali')); 
        // print_r($this->getLayout()->createBlock('sonali/test_sonali')); 
        print_r(Mage::helper('sonali/sonali')); 
        print_r(Mage::helper('sonali')); 
    }
  
}