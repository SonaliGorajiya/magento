<?php

class Ccc_Practice_Adminhtml_OneController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        echo '<pre>';
        //Task : 1. How you will prepare different types of queries and take a collection of rows in object format and array format.
        $model = Mage::getModel('practice/practice');
        $collection = $model->getResourceCollection();
        // print_r($collection);
        print_r($collection->toArray());
        $adapter = $collection->getConnection('core_read');
        print_r(get_class($adapter->select()));
        $query = $adapter->select()->from('product')->where("product_id = 1");
        echo $query;echo '<br>';
        $data = $adapter->fetchRow($query);
        print_r($data);
    }

}