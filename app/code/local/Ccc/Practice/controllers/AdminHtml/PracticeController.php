<?php
class Ccc_Practice_Adminhtml_PracticeController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
        $collection = Mage::getModel('product/product');
        print_r($collection);
        die;
    }

}