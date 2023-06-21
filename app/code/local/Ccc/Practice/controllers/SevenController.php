<?php

class Ccc_Practice_SevenController extends Mage_Core_Controller_Front_Action
{
    

    public function indexAction()
    {
        echo'<pre>';
        $adapter = Mage::getModel('practice/practice')->getCollection()->getConnection();
        // print_r($adapter);
        print_r(get_class_methods($adapter));

    }


}
