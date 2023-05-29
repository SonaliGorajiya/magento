<?php 

class Sonali_Idx_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        // echo "111";
        echo '<pre>';
        // print_r(get_class_methods("Sonali_Idx_IndexController"));
        // print_r(Mage::getModel('idx/idx')); 
        // print_r($this->getLayout()->createBlock('idx/test_idx')); 
        print_r(Mage::helper('idx/idx')); 
        print_r(Mage::helper('idx')); 
    }
  
}