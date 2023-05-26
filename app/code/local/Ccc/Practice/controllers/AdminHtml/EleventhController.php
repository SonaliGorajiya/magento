// Task : 11. Understand methods related to the controller parent class and understand how to use it along with messages class.

<?php

class Ccc_Practice_Adminhtml_EleventhController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
        echo "<pre>";
        print_r(get_class_methods($this));

	}
}
