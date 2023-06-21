<?php
class Ccc_Practice_Class_SixController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
       
     //   6.How to prepare queries based on SQL SELECT class and fetch records in object format and array format?

    // create an instance of the SQL SELECT class
    $select = Mage::getSingleton('core/resource')->getConnection('core_read')->select();

    //prepare the query 

    $select->from('product', array('sku', 'cost', 'price'))
           ->where('status = ?', '1')
           ->order('created_at DESC')
           ->limit(10);

    $connection = Mage::getSingleton('core/resource')->getConnection('core_read');

    // records in array format
    $recordsArray = $connection->fetchAll($select);
    
    // records in object format
    $recordsObject = $connection->fetchAll($select, array(), Zend_Db::FETCH_OBJ);
    print_r($recordsObject);
            die;

    }

}