<?php

class Ccc_Practice_FiveController extends Mage_Core_Controller_Front_Action
{
    

    public function indexAction()
    {
        echo'<pre>';
        $collection = new Ccc_Practice_Model_Resource_Practice_Collection();
        echo $collection->getSelect()->where('vendor_id = 10');
        print_r($collection->toArray());
        print_r($collection->getItems());
        print_r($collection->getData());

    }


}
