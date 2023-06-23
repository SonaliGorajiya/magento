<?php

class Ccc_Practice_TwoController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo'<pre>';
        $collection = new Ccc_Practice_Model_Resource_Practice_Collection();
        $model = new Ccc_Practice_Model_Practice();

        $query = "INSERT INTO `vendor`(`first_name`, `last_name`, `email`, `gender`, `mobile`, `status`, `company`) VALUES ('name2','lastname2','email2@gmail.com','1','12345','1','Ccc')";

        $collection->getConnection('core_write')->query($query);

        print_r($collection->getData());
    }
}
