// Task : 3. How to insert a single row into a table using a row object ?

<?php

class Ccc_Practice_Adminhtml_ThirdController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
        echo "<pre>";

        $product = Mage::getModel('product/product');

        $data = array(
            'name' => 'test',
            'sku' => 'sku',
            'cost' => '50',
            'price' => '500'
        );
        $row = $product->setData($data);

        if ($row->save()) 
        {
            echo "First Row Inserted Successfully.";
        }
	}
}
