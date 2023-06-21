<?php

class Ccc_Practice_SixthController extends Mage_Core_Controller_Front_Action
{
    

    public function indexAction()
    {
        echo'<pre>';
        $collection = new Ccc_Practice_Model_Resource_Practice_Collection();

        echo $query = "SELECT * FROM `vendor` where `vendor_id`= 10 OR `vendor_id` = 36";

        // print_r(get_class_methods($collection->getConnection()->select()));
        print_r($collection->getConnection()->fetchAll($query));

    }


}
