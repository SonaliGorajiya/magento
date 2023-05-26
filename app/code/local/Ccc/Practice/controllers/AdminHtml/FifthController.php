// Task : 5. How to prepare queries based on collection class and fetch records in object format and array format?

<?php

class Ccc_Practice_Adminhtml_FifthController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
        echo "<pre>";

        $collection = Mage::getModel('product/product')->getCollection();

        $collection->addFieldToFilter('status', array('eq' => 1));
        // $collection->addFieldToFilter('status', array('neq' => 1));

        // fetch the records as an array
        $recordsArray = $collection->getData();
        print_r($recordsArray); 

        // fetch the records as an object
        $recordsObject = $collection->getItems();
	}
}
