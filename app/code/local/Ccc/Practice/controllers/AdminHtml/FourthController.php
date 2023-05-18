// Task : 4. How to insert multiple rows at a time when required to insert multiple rows into a table ? Check the function.

<?php

class Ccc_Practice_Adminhtml_FourthController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
        echo "<pre>";

        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        $tableName = $connection->getTableName('product');

        $rows = array(
            array(
                'name' => 'test2',
                'sku' => 'sku2',
                'cost' => '100',
                'price' => '1000',
                'description' => 'this is test 2'
            ),
            array(
                'name' => 'test3',
                'sku' => 'sku3',
                'cost' => '200',
                'price' => '2000',
                'description' => 'this is test 3'
            ),
        );

        if($connection->insertArray($tableName, array('name', 'sku', 'cost', 'price', 'description'), $rows))
        {
            echo "Mupltiple rows Inserted Successfully.";
        }
	}
}
