<?php

class Ccc_Practice_TenController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo'<pre>';
        $model = Mage::getModel('practice/practice');

        print_r(get_class_methods($this->getLayout()));
        print_r(get_class_methods('Mage_Core_Block_Abstract'));
    }
}
