// Task : 19. How to overweite core or local controller action into local folder? Prepare 3 examples.

<?php 
require_once(Mage::getModuleDir('controllers','Mage_Adminhtml').DS.'Catalog'.DS.'ProductController.php');
class Ccc_Practice_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{
    public function indexAction()
    {
        echo '<pre>';
        echo "123";
        echo '<pre>';
        // print_r(get_class_methods("Ccc_practice_IndexController"));
        // print_r(Mage::getModel('practice/practice')); 
        // print_r($this->getLayout()->createBlock('practice/practice')); 
        print_r(Mage::helper('practice/practice')); 
        print_r(Mage::helper('practice')); 
    }
  
}