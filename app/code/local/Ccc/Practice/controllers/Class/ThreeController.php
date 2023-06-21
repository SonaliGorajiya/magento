<?php
class Ccc_Practice_Class_ThreeController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
        $productRow = Mage::getModel('product/product');

        $data = array(
            'sku' => '44',
            'cost' => '1100',
            'price' => '1100'
        );
        // $row = $productRow->getDataModel()->createRow($data);
        $row = $productRow->setData($data);

        if($row->save())
        {
            echo "data saved";
        }
    }

}