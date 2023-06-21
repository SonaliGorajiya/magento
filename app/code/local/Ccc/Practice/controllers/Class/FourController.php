<?php
class Ccc_Practice_Class_FourController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
        // 4.  How to insert multiple rows at a time when required to insert multiple rows into a table ? Check the function.

           $productRow = Mage::getModel('product/product');

        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        $tableName = $connection->getTableName('product');

        $rows = array(
            array(
                'sku' => 'nokia 1100',
                'cost' => '1100',
                'price' => '1100'
            ),
            array(
                'sku' => 'nokia 1200',
                'cost' => '1200',
                'price' => '1200'
            )
        );

        if($connection->insertArray($tableName, array('sku', 'cost', 'price'), $rows))
        {
            echo "multiple row inserted";
        }

    }

}