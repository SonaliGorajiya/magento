<?php
<<<<<<< HEAD
/**
 * 
 */
class Ccc_Practice_QueryController extends Mage_Core_Controller_Front_Action
{
	
	public function indexAction()
	{
		echo "<pre>";
		echo "string";
		$resource = Mage::getSingleton('core/resource');
=======

class Ccc_Practice_QueryController extends Mage_Core_Controller_Front_Action
{
    
    public function indexAction()
    {
        echo "<pre>";

        $resource = Mage::getSingleton('core/resource');
>>>>>>> 951342cae5b76368de12cc641e7a370b2143c2e4
        $write = $resource->getConnection('core_write');
        $product = $resource->getTableName('product/product');
        $idx = $resource->getTableName('idx/idx');

        // $write->insert($product,array('sku' => 'SA2', 'price' => 1100));
<<<<<<< HEAD

        //read 
        // left join
        echo $select = $write->select()
            ->from(['t' => $product], ['product_id', 'status'])
            ->joinLeft(['t2' => $idx], 't.product_id = t2.product_id', ['brand_id','collection_id'])   
            ->group('t2.cost')
            ->where('t.cost LIKE ?', "%1100%");
=======
        //read 
        // left join
        echo $select = $write->select()
            ->from(['p' => $product], ['product_id', 'status'])
            ->joinLeft(['t2' => $idx], 'p.product_id = t2.product_id', ['brand_id','collection_id'])   
            ->group('t2.cost')
            ->where('p.cost LIKE ?', "%1100%");
>>>>>>> 951342cae5b76368de12cc641e7a370b2143c2e4

        $results = $write->fetchAll($select);
        $write->update(
            $product,
            ['sku' => 'ABCSD', 'cost' => 5000],
            ['product_id = ?' => 12]
        );



        // Delete:

        $write->delete(
            $product,
            ['product_id IN (?)' => [4, 5]]
        );


        // Insert Multiple:

        $data = [
            ['sku'=>'sku4', 'name'=>'name2', 'cost'=>555],
            ['sku'=>'sku55', 'name'=>'name4', 'cost'=>666],
        ];
        $write->insertMultiple($product, $data);


        // Insert Update On Duplicate:

        $data = [];
        $data[] = [
            'sku' => 'sku55',
            'cost' => 1500
        ];

        $write->insertOnDuplicate(
            $product,
            $data, 
            ['cost'] 
        );
        
        print_r($results);
        die;
<<<<<<< HEAD

        // insert on duplicate table to table

        // INSERT INTO catalog_product_entity_int (entity_type_id, attribute_id, store_id,entity_id,value) SELECT 4 , 98 , 0 , product_id , status FROM import_product_idx AS s ON DUPLICATE KEY UPDATE value = s.status;
		
	}
=======
 
        // insert on duplicate table to table

        // INSERT INTO catalog_product_entity_int (entity_type_id, attribute_id, store_id,entity_id,value) SELECT 4 , 98 , 0 , product_id , status FROM import_product_idx AS s ON DUPLICATE KEY UPDATE value = s.status;
        
    }
>>>>>>> 951342cae5b76368de12cc641e7a370b2143c2e4
}