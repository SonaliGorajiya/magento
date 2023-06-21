<?php
class Ccc_Practice_ClassoneController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {

        //1. How you will prepare different types of queries and take a collection of rows in  object format and array format.

        $collection = Mage::getModel('product/product')->getCollection();
        echo "<pre>";

        // collection of rows in  object format.
        // print_r($collection);

        // collection of rows in array format.
        // print_r($collection->toArray());

        // prepare different types of queries
        
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $select = $read->select()
            ->from('product', array('sku', 'cost', 'price'))
            ->where('status = ?', 1);
        $rows = $read->fetchAll($select);

        print_r($rows);

        die;
    }

}