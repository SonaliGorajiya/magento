<?php
class Ccc_Practice_Class_SevenController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
        // 7. Check all methods available in our adapter class and find out how it works in Magento ?
       echo "<pre>";
       $adapter = Mage::getSingleton('core/resource')->getConnection('core_read');
       print_r(get_class_methods($adapter));
        die;

    }

}