// Task : 19. How to overweite core or local controller action into local folder? Prepare 3 examples.

<?php 
require_once(Mage::getModuleDir('controllers','Ccc_Product').DS.'IndexController.php');
// require_once('C:\xampp\htdocs\2023\magento\magento-mirror\app\code\local\Ccc\Product\controllers\IndexController.php');
class Ccc_Practice_IndexController extends Ccc_Product_IndexController
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