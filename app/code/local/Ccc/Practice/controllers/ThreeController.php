<?php

class Ccc_Practice_ThreeController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo'<pre>';
        $collection = new Ccc_Practice_Model_Resource_Practice_Collection();
        $model = new Ccc_Practice_Model_Practice();

        $data = [
            'first_name' => 'name2',
            'last_name' => 'lastname',
            'email' => 'gamil@gmail.com',
            'gender' => '1',
            'mobile' => '1457815645',
            'status' => '1',
            'company' => 'Ccc',
            'created_at' => '2023-05-08 04:59:24',
            'updated_at' => '2023-05-08 05:00:15 '];

        print_r($model->addData($data)->save());

        print_r($collection->getData());
    }
}
