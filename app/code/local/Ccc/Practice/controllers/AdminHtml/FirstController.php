// Task : 1. How you will prepare different types of queries and take a collection of rows in  object format and array format.

<?php

class Ccc_Practice_Adminhtml_FirstController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo "<pre>";

        // Collection of rows in object
        $collection = Mage::getModel('product/product')->getCollection();
        // print_r($collection);

        // Collection of rows in Array
        $collectionArray = Mage::getModel('product/product')->getCollection()->toArray();
        print_r($collectionArray);
        
        // different types of queries

        $adapter = Mage::getSingleton('core/resource')->getConnection('core_read');
        $select = $adapter->select()
            ->from('product', array('name', 'cost', 'price'))
            ->where('name = ?', 'soap');
        $rows = $adapter->fetchAll($select);

        print_r($rows);
    }
}
