<?php

class Ccc_Practice_EightController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo'<pre>';
        $resource = Mage::getModel('practice/practice')->getResource();

        print_r(get_class_methods($resource));
    }
}
