// Task : 2. How to insert a single row into a table using a query string ?

<?php

class Ccc_Practice_Adminhtml_SecondController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
        echo "<pre>";

        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $tableName = $resource->getTableName('product');

        $query = "INSERT INTO {$tableName} (`name`, `sku`, `cost`, `price`, `description`, `status`) VALUES ('realme', 'C25-Y', '15000', '120000', 'This is Realme Description', '2')";
        
        if($writeConnection->query($query))
        {
            echo "Inserted Successfully";
        }
	}
}
