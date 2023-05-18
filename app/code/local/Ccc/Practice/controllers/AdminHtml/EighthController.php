// Task : 8. Check all methods available in our resource class and find out how it works in Magento ?

<?php

class Ccc_Practice_Adminhtml_EighthController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{
        $resource = Mage::getSingleton('core/resource');
        echo "<pre>";
        print_r(get_class_methods($resource));
	}
}
