<?php
class Ccc_Practice_ClasstwoController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $query = "INSERT INTO `product` (`product_name`, `sku`, `cost`, `price`, `quantity`, `description`, `status`, `url`, `color`, `matrial`) VALUES ('nokia 1100','nokia','1100','1100','1100','nice','1','1','ff','1');";
        if($writeConnection->query($query))
        {
            echo "query executed";
        }
        die;

    }

}