// Task : 10. Understand and practice parent classes methods related to layout and blocks.

<?php

class Ccc_Practice_Adminhtml_TenthController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{
        echo "<pre>";
        echo 'classes are';
        echo '
            Mage_Core_Block_Abstract
            Mage_Core_Block_Template
            Mage_Core_Block_Text
            Mage_Core_Model_Layout
            Mage_Core_Controller_Varien_Action'
        ;
	}
}
