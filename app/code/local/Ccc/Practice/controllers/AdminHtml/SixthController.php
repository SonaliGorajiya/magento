// Task : 6. How to prepare queries based on SQL SELECT class and fetch records in object format and array format?

<?php

class Ccc_Practice_Adminhtml_SixthController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{

        $select = Mage::getSingleton('core/resource')->getConnection('core_read')->select();

        $select->from('product', array('product_id', 'name', 'sku', 'status'))
               ->where('status = ?', '1')
               ->order('product_id ASC')
               ->limit(4);

        // fetch the records as an array
        $recordsArray = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($select);
        echo "<pre>";
        // print_r($recordsArray);die;

        // fetch the records as an object
        $recordsObject = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($select, array(), Zend_Db::FETCH_OBJ);
        print_r($recordsObject);
	}
}
