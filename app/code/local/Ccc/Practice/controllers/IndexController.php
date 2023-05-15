<?php 

class Ccc_Practice_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        // echo "111";
        echo '<pre>';
        // print_r(get_class_methods("Ccc_practice_IndexController"));
        // print_r(Mage::getModel('practice/practice')); 
        // print_r($this->getLayout()->createBlock('practice/practice')); 
        print_r(Mage::helper('practice/practice')); 
        print_r(Mage::helper('practice')); 
    }
  
}