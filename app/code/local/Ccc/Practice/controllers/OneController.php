<?php

class Ccc_Practice_OneController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo'<pre>';
        // $collection = new Ccc_Practice_Model_Resource_Practice_Collection();

        // echo $collection->getSelect();
        // print_r($collection->getData());

        // echo $collection
        //     ->getSelect()
        //     ->joinRight(
        //         array('va'=> 'vendor_address'),
        //         "va.vendor_id = main_table.vendor_id"
        //     );
        // print_r($collection->getData());

        // print_r(get_class_methods($collection));


        print_r(get_class_methods(Mage::getVersionInfo()));
        echo "<br>";

        // print_r(get_class_methods(Mage));
        // echo "<br>";

        // print_r(get_class_methods(Mage));
        // echo "<br>";

        // print_r(get_class_methods(Mage));
        // echo "<br>";

        // print_r(get_class_methods(Mage));
        // echo "<br>";

        // print_r(get_class_methods(Mage));
        // echo "<br>";

        // print_r(get_class_methods(Mage));
        // echo "<br>";

        print_r(get_class_methods(Mage));
        echo "<br>";
    }
}
