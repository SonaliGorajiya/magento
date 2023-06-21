<?php

class Ccc_Practice_NineController extends Mage_Core_Controller_Front_Action
{
    

    public function indexAction()
    {
        echo'<pre>';
        $row = Mage::getModel('practice/practice');

        print_r(get_class_methods($row));

    }


}
