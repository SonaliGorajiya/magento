<?php
class Ccc_Practice_Class_FiveController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
        echo "<pre>";
       // 5. How to prepare queries based on collection class and fetch records in object format and array format?
        $collection = Mage::getModel('product/product')->getCollection();

        // add filters to the collection
        $collection->addFieldToFilter('status', array('eq' => 1));
        echo $collection->getSelect();

        // fetch the records as an array
        $recordsArray = $collection->getData();

        // fetch the records as an object
        $recordsObject = $collection->getItems();

        print_r($recordsObject);
    }

}