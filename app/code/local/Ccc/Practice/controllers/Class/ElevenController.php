<?php
class Ccc_Practice_Class_ElevenController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
       echo "<pre>";
       print_r(get_class_methods($this));


    //    for messege purpose
    
    // Mage::getSingleton('core/session')->addSuccess('success message.');

    // Mage::getSingleton('core/session')->addError('error message.');

    // Mage::getSingleton('core/session')->addNotice('informative message.');

    // Mage::getSingleton('core/session')->addWarning('warning message.');
    
        die;

    }

}