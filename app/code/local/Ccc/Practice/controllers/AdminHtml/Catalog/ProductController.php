<?php
require_once 'C:\xampp\htdocs\2023\magento\magento-mirror\app\code\core\Mage\Adminhtml\controllers\Catalog\ProductController.php';
class Ccc_Practice_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{
   public function indexAction()
    {
        $this->_title($this->__('Catalog'))
             ->_title($this->__('Manage Products'));

        $this->loadLayout();
        $this->renderLayout();
    }
}
