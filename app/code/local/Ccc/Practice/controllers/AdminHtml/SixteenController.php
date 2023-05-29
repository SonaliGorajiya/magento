// Task : 16. How to create and declare observer into XML ? How it can be used.

<?php

class Ccc_Practice_Adminhtml_SixteenController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{
        echo "<pre>";

        $model = Mage::getModel('practice/practice');

        Mage::dispatchEvent('cms_page_prepare_save', array('page' => $model, 'request' => $this->getRequest()));
	}
}
