<?php
class Ccc_Practice_Class_TenController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
       echo "<pre>";
       
       // Mage_Core_Block_Abstract
        $blockTemplate = new Mage_Core_Block_Template();
        // print_r(get_class_methods($blockTemplate));

        $blockText = new Mage_Core_Block_Text();
        // print_r(get_class_methods($blockText));


        // $blockClass = new Mage_Core_Model_Layout();
        // print_r(get_class_methods($blockClass));

        $blockGridContainer = new Mage_Adminhtml_Block_Widget_Grid_Container();
        print_r(get_class_methods($blockGridContainer));
        
        die;

    }

}