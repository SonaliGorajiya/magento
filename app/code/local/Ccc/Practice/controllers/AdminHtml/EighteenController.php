// Task : 18. How to overweite core or local helpers into local folder? Prepare 3 examples.

<?php

class Ccc_Practice_Adminhtml_EighteenController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{
        echo "<pre>";

        $model = Mage::helper('practice');
        print_r($model);
	}
}
