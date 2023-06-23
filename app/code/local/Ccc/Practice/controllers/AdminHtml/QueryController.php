<?php

class Ccc_Practice_Adminhtml_QueryController extends Mage_Adminhtml_Controller_Action
{
    function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/practice'));
        $this->renderLayout();
    }

    public function oneAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_one'));
        $this->renderLayout();
    }

    public function twoAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_two'));
        $this->renderLayout();
    }

    public function threeAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_three'));
        $this->renderLayout();
    }

    public function fourAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_four'));
        $this->renderLayout();
    }

    public function fiveAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_five'));
        $this->renderLayout();
    }

    public function sixAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_six'));
        $this->renderLayout();
    }

    public function sevenAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_seven'));
        $this->renderLayout();
    }

    public function eightAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_eight'));
        $this->renderLayout();
    }

    public function nineAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_nine'));
        $this->renderLayout();
    }

    public function tenAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_ten'));
        $this->renderLayout();
    }

    public function viewoneAction()
    {
        echo "1. Need a list of product with these columns product name, sku, cost, price, color. <br><br>";
        try{
            echo "Core Query : <br><br>";
            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');

            $tableName = $resource->getTableName('catalog/product');
            echo $select = $readConnection->select()
                ->from(array('p' => $tableName), array(
                    'sku' => 'p.sku',
                    'name' => 'pv.value',
                    'cost' => 'pdc.value',
                    'price' => 'pdp.value',
                    'color' => 'pi.value',
                ))
                ->joinLeft(
                    array('pv' => $resource->getTableName('catalog_product_entity_varchar')),
                    'pv.entity_id = p.entity_id AND pv.attribute_id = 73',
                    array()
                )
                ->joinLeft(
                    array('pdc' => $resource->getTableName('catalog_product_entity_decimal')),
                    'pdc.entity_id = p.entity_id AND pdc.attribute_id = 81',
                    array()
                )
                ->joinLeft(
                    array('pdp' => $resource->getTableName('catalog_product_entity_decimal')),
                    'pdp.entity_id = p.entity_id AND pdp.attribute_id = 77',
                    array()
                )
                ->joinLeft(
                    array('pi' => $resource->getTableName('catalog_product_entity_int')),
                    'pi.entity_id = p.entity_id AND pi.attribute_id = 94',
                    array()
                );

            echo "<br><br> Magento Query : <br><br>";
            print_r('$collection = Mage::getModel("catalog/product")->getCollection();<br>
        $collection->addAttributeToSelect("name")
            ->addAttributeToSelect("sku")
            ->addAttributeToSelect("cost")
            ->addAttributeToSelect("price")
            ->addAttributeToSelect("color");');
        echo "<br><br>";

        echo "Core Query : <br><br>
        SELECT
                p.sku,
                pv.value AS name,
                pdc.value AS cost,
                pdp.value AS price,
                pi.value AS color
            FROM
                catalog_product_entity p
            LEFT JOIN
                catalog_product_entity_varchar pv
            ON
                pv.entity_id = p.entity_id
                AND pv.attribute_id = (
                    SELECT attribute_id
                    FROM eav_attribute
                    WHERE attribute_code = 'name'
                    AND entity_type_id = (
                        SELECT entity_type_id
                        FROM eav_entity_type
                        WHERE entity_type_code = 'catalog_product'
                    )
                )
            LEFT JOIN
                catalog_product_entity_decimal pdc
            ON
                pdc.entity_id = p.entity_id
                AND pdc.attribute_id = (
                    SELECT attribute_id
                    FROM eav_attribute
                    WHERE attribute_code = 'cost'
                    AND entity_type_id = (
                        SELECT entity_type_id
                        FROM eav_entity_type
                        WHERE entity_type_code = 'catalog_product'
                    )
                )
            LEFT JOIN
                catalog_product_entity_decimal pdp
            ON
                pdp.entity_id = p.entity_id
                AND pdp.attribute_id = (
                    SELECT attribute_id
                    FROM eav_attribute
                    WHERE attribute_code = 'price'
                    AND entity_type_id = (
                        SELECT entity_type_id
                        FROM eav_entity_type
                        WHERE entity_type_code = 'catalog_product'
                    )
                )
                LEFT JOIN
                    catalog_product_entity_int pi
                ON
                    pi.entity_id = p.entity_id
                    AND pi.attribute_id = (
                        SELECT attribute_id
                        FROM eav_attribute
                        WHERE attribute_code = 'color'
                        AND entity_type_id = (
                            SELECT entity_type_id
                            FROM eav_entity_type
                            WHERE entity_type_code = 'catalog_product'
                        )
                    );
                <br><br>";


        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }       
        
    }

    public function viewtwoAction()
    {
        echo "2. Need a list of attribute & options. return an array with attribute id, attribute code, option Id, option name. <br><br>";
        try{
            echo "Core Query : <br><br>";
            echo "SELECT a.attribute_id, a.attribute_code, ao.option_id, aov.value FROM eav_attribute AS a LEFT JOIN eav_attribute_option AS ao ON a.attribute_id = ao.attribute_id LEFT JOIN eav_attribute_option_value AS aov ON ao.option_id = aov.option_id WHERE a.entity_type_id = ( SELECT entity_type_id FROM eav_entity_type WHERE entity_type_code = 'catalog_product' ) AND ao.option_id IS NOT NUll";

            echo "<br><br> Magento Query : <br><br>";
            print_r('$attributeCollection = Mage::getResourceModel("eav/entity_attribute_collection");
        <br>

        $attributeOptionCollection = Mage::getResourceModel("eav/entity_attribute_option_collection");
        <br>
        $attributeOptionCollection->getSelect()
            ->join(
                array("attribute" => $attributeCollection->getTable("eav/attribute")),
                "attribute.attribute_id = main_table.attribute_id",
                array("attribute_code" => "attribute.attribute_code")
            )
            ->join(
                array("option_value" => $attributeCollection->getTable("eav/attribute_option_value")),
                "option_value.option_id = main_table.option_id",
                array("value")
            );
        <br>

        $attributeOptionCollection->getSelect()->columns(array(
            "attribute_id" => "main_table.attribute_id",
            "attribute_code" => "attribute.attribute_code",
            "option_id" => "main_table.option_id",
        ));');


        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        
    }

    public function viewthreeAction()
    {
        echo "3. Need a list of attribute having options count greater than 10. return array with attribute id, attribute code, option count.<br><br>";
        try{
            echo "Core Query : <br><br>";

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $subquery = $readConnection->select()
            ->from(
                array('opt' => $resource->getTableName('eav/attribute_option')),
                array('attribute_id', 'option_count' => new Zend_Db_Expr('COUNT(opt.option_id)'))
            )
            ->group('opt.attribute_id')
            ->having('option_count > ?', 10);

            $query = $readConnection->select()
            ->from(
                array('main_table' => $resource->getTableName('eav/entity_attribute')),
                array('attribute_id')
            )
            ->join(
                array('attr' => $resource->getTableName('eav/attribute')),
                'attr.attribute_id = main_table.attribute_id',
                array('attribute_code')
            )
            ->joinLeft(
                array('sub' => new Zend_Db_Expr('(' . $subquery . ')')),
                'sub.attribute_id = main_table.attribute_id',
                array('option_count' => 'sub.option_count')
            )
            ->where('sub.option_count > 10');

            echo $query->__toString();

            echo "<br><br>Magento Query : <br><br>";
            print_r('$attributeOptionCollection = Mage::getResourceModel("eav/entity_attribute_option_collection")
            ->addFieldToFilter("option_id", array("gt" => 0))
            ->getSelect()
            ->join(
                array("attribute" => Mage::getSingleton("core/resource")->getTableName("eav/attribute")),
                "attribute.attribute_id = main_table.attribute_id",
                array("attribute_code" => "attribute.attribute_code")
            )
            ->columns(array("option_count" => new Zend_Db_Expr("COUNT(main_table.option_id)")))
            ->group("main_table.attribute_id")
            ->having("option_count > ?", 10);<br>

            $resultCollection = Mage::getModel("eav/entity_attribute")->getCollection();<br>
            $resultCollection->getSelect()->reset()->from(array("main_table" => $attributeOptionCollection));');


        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        
    }

    public function viewfourAction()
    {
        echo "4. Need list of product with assigned images. return an array with product Id, sku, base image, thumb image, small image. <br>";
        try{
            echo "<pre>";

            echo "Core Query : SELECT 
                p.entity_id AS product_id,
                p.sku,
                i1.value AS base_image,
                i2.value AS thumb_image,
                i3.value AS small_image
            FROM 
                catalog_product_entity AS p
            LEFT JOIN 
                catalog_product_entity_varchar AS i1 ON (p.entity_id = i1.entity_id AND i1.attribute_id = (
                    SELECT attribute_id FROM eav_attribute WHERE attribute_code = 'image' AND entity_type_id = (
                        SELECT entity_type_id FROM eav_entity_type WHERE entity_type_code = 'catalog_product'
                    )
                ))
            LEFT JOIN 
                catalog_product_entity_varchar AS i2 ON (p.entity_id = i2.entity_id AND i2.attribute_id = (
                    SELECT attribute_id FROM eav_attribute WHERE attribute_code = 'thumbnail' AND entity_type_id = (
                        SELECT entity_type_id FROM eav_entity_type WHERE entity_type_code = 'catalog_product'
                    )
                ))
            LEFT JOIN 
                catalog_product_entity_varchar AS i3 ON (p.entity_id = i3.entity_id AND i3.attribute_id = (
                    SELECT attribute_id FROM eav_attribute WHERE attribute_code = 'small_image' AND entity_type_id = (
                        SELECT entity_type_id FROM eav_entity_type WHERE entity_type_code = 'catalog_product'
                    )
                ));";

            echo "<br><br>Magento Query : <br><br>";
            echo '$collection = Mage::getModel("catalog/product")->getCollection();
$collection->addAttributeToSelect("entity_id")
           ->addAttributeToSelect("sku")
           ->addAttributeToSelect("image")
           ->addAttributeToSelect("smallimage")
           ->addAttributeToSelect("thumbnail")
           ->addAttributeToFilter("image", array("notnull" => true));
            ';
            echo "<br>";
            echo "New Core Query : <br>";
            $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        echo $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('catalog_product_entity')),
                array('entity_id','sku')
            )
            ->joinLeft(
                array('image'=>$resource->getTableName('catalog_product_entity_varchar')),
                'image.entity_id = main_table.entity_id AND image.attribute_id = 87',
                array('image' => 'image.value')
            )
            ->joinLeft(
                array('thumb'=>$resource->getTableName('catalog_product_entity_varchar')),
                'thumb.entity_id = main_table.entity_id AND thumb.attribute_id = 89',
                array('thumbnail' => 'thumb.value')
            )
            ->joinLeft(
                array('small'=>$resource->getTableName('catalog_product_entity_varchar')),
                'small.entity_id = main_table.entity_id AND small.attribute_id = 88',
                array('small' => 'small.value')
            );


        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
    }

    public function viewfiveAction()
    {
        echo "5. Need list of product with gallery image count. return an array with product sku, gallery images count, without consideration of thumb, small, base.<br>";
        try{
            echo "<pre>";

            echo "Core Query : SELECT 
                e.sku AS product_sku,
                COUNT(g.value_id) AS gallery_image_count
            FROM
                catalog_product_entity AS e
            LEFT JOIN
                catalog_product_entity_media_gallery AS g ON e.entity_id = g.entity_id
            GROUP BY
                e.entity_id;
        <br><br>";

            echo "Magento Query : <br><br>";
            echo '$collection = Mage::getResourceModel("catalog/product_collection");
        $collection->getSelect()
        ->joinLeft(
            array("g" => $collection->getTable("catalog/product_attribute_media_gallery")),
            "e.entity_id = g.entity_id",
            array("gallery_image_count" => "COUNT(g.value_id)")
        )
        ->group("e.entity_id");
        $collection->addAttributeToSelect("sku");';


        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
    }

    public function viewsixAction()
    {
        echo "6. Need list of top to bottom customers with their total order counts. return an array with customer id, customer name, customer email, order count.<br>";
        try{
            echo "<pre>";

            echo "Core Query : SELECT 
                c.entity_id, c.email, cv.value, COUNT(og.entity_id) AS count 
                FROM customer_entity AS c 
                LEFT JOIN customer_entity_varchar as cv ON cv.attribute_id = 5 AND cv.entity_id = c.entity_id
                LEFT JOIN sales_flat_order_grid as og ON og.customer_id = c.entity_id
                GROUP BY c.entity_id 
                ORDER BY count DESC;
                <br><br>";

            echo "Magento Query : <br><br>";
            echo '$collection = Mage::getModel("customer/customer")->getCollection();
        $collection->getSelect()
            ->joinLeft(
                array("o" => $collection->getTable("sales/order")),
                "e.entity_id = o.customer_id",
                array("order_count" => "COUNT(o.entity_id)")
            )
            ->group("e.entity_id")
            ->order("order_count DESC");

        $collection->addAttributeToSelect("firstname");
        $collection->addAttributeToSelect("email");';


        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        
    }

    public function viewsevenAction()
    {
        echo "7. Need list of top to bottom customers with their total order counts, order status wise. return an array with customer id, customer name, customer email, status, order count.<br>";

        try{
            echo "<pre>";

            echo "Core Query : SELECT 
                    c.entity_id, cv.value, c.email, og.status, COUNT(og.entity_id) AS count 
            FROM customer_entity AS c 
            LEFT JOIN customer_entity_varchar as cv ON cv.attribute_id = 5 AND cv.entity_id = c.entity_id
            LEFT JOIN sales_flat_order_grid as og ON og.customer_id = c.entity_id
            GROUP BY c.entity_id 
            ORDER BY count DESC;
            <br><br>";

            echo "Magento Query : <br><br>";
            echo '$collection = Mage::getModel("customer/customer")->getCollection()
            ->addAttributeToSelect("email");

        $collection->getSelect()
            ->joinLeft(
                array("cv" => Mage::getSingleton("core/resource")->getTableName("customer_entity_varchar")),
                "cv.attribute_id = 5 AND cv.entity_id = e.entity_id",
                array("firstname" => "cv.value")
            )
            ->joinLeft(
                array("og" => Mage::getSingleton("core/resource")->getTableName("sales_flat_order_grid")),
                "og.customer_id = e.entity_id",
                array("status" => "og.status", "count" => "COUNT(og.entity_id)")
            )
            ->group("e.entity_id")
            ->order("count DESC");';

        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        
    }

    public function vieweightAction()
    {
        echo "8. Need list product with number of quantity sold till now for each. return an array with product id, sku, sold quantity. <br>";

        try{
            echo "<pre>";

            echo "Core Query : SELECT 
                p.entity_id AS product_id, p.sku, SUM(oip.qty_ordered) AS sold_quantity
            FROM catalog_product_entity AS p
            INNER JOIN sales_flat_order_item AS oip ON oip.product_id = p.entity_id
            WHERE oip.parent_item_id IS NULL
            GROUP BY p.entity_id;
            <br><br>";

            echo "Magento Query : <br><br>";
            echo '$collection = Mage::getResourceModel("sales/order_item_collection")
            ->addFieldToSelect(array("product_id", "sku"));

        $collection->getSelect()
            ->columns(array("sold_quantity" => "SUM(qty_ordered)"))
            ->group(array("product_id", "sku"));

        $this->setCollection($collection);';

        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

    }

    public function viewnineAction()
    {
        echo "9. Need list of those attributes for whose value is not assigned to product. return an array result product wise with these columns product Id, sku, attribute Id, attribute code.<br>";

         try{
            echo "<pre>";

            echo "Core Query : SELECT
                e.entity_id AS product_id,
                e.sku AS sku,
                a.attribute_id,
                a.attribute_code
            FROM
                eav_attribute AS a
            CROSS JOIN
                catalog_product_entity AS e
            LEFT JOIN
                catalog_product_entity_varchar AS v
                ON v.attribute_id = a.attribute_id
                AND v.entity_id = e.entity_id
            LEFT JOIN
                catalog_product_entity_int AS i
                ON i.attribute_id = a.attribute_id
                AND i.entity_id = e.entity_id
            LEFT JOIN
                catalog_product_entity_decimal AS d
                ON d.attribute_id = a.attribute_id
                AND d.entity_id = e.entity_id
            WHERE
                (v.value IS NULL OR v.value = '')
                AND (i.value IS NULL OR i.value = '')
                AND (d.value IS NULL OR d.value = '')
                AND a.entity_type_id = (
                    SELECT entity_type_id FROM eav_entity_type WHERE entity_type_code = 'catalog_product'
                )
                AND a.is_user_defined = 1;
            <br><br>";

            echo "Magento Query : <br><br>";
            echo '$collection = Mage::getResourceModel("catalog/product_collection")
            ->addAttributeToSelect("sku");

        $attributes = Mage::getResourceModel("catalog/product_attribute_collection")
            ->addFieldToFilter("is_user_defined", 1)
            ->getItems();

        foreach ($attributes as $attribute) {
            $attributeCodes[] = $attribute->getAttributeCode();
        }

        $unassignedAttributes = array();

        $products = Mage::getModel("catalog/product")->getCollection()
            ->addAttributeToSelect("sku");


        foreach ($products as $product) {
            $productId = $product->getId();
            $sku = $product->getSku();

            foreach ($attributeCodes as $attributeCode) {
                $attribute = Mage::getSingleton("eav/config")->getAttribute("catalog_product", $attributeCode);
                $attributeId = $attribute->getId();

                $resource = Mage::getResourceModel("catalog/product");
                $value = $resource->getAttributeRawValue($productId, $attributeCode, Mage::app()->getStore());

                if ($value === false || $value === null) {
                    $unassignedAttributes[] = array(
                        "product_id" => $productId,
                        "sku" => $sku,
                        "attribute_id" => $attributeId,
                        "attribute_code" => $attributeCode
                    );
                }
            }
        }';

        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        
    }

    public function viewtenAction()
    {
        echo "10. Need list of those attributes for whose value is not assigned to product. return an array result product wise with these columns product Id, sku, attribute Id, attribute code, value.<br>";

        try{
            echo "<pre>";

            echo "Core Query : SELECT
                cpe.entity_id AS product_id,
                cpe.sku,
                eav.attribute_id,
                eav.attribute_code,
                IF(eav.backend_type = 'int' OR eav.backend_type = 'decimal', eav_int.value, eav_varchar.value) AS value
            FROM
                catalog_product_entity AS cpe
            INNER JOIN
                eav_entity_type AS et ON et.entity_type_code = 'catalog_product' AND et.entity_type_id = cpe.entity_type_id
            INNER JOIN
                eav_attribute AS eav ON eav.entity_type_id = et.entity_type_id AND eav.is_user_defined = 1
            LEFT JOIN
                catalog_product_entity_int AS eav_int ON eav_int.attribute_id = eav.attribute_id AND eav_int.entity_id = cpe.entity_id
            LEFT JOIN
                catalog_product_entity_varchar AS eav_varchar ON eav_varchar.attribute_id = eav.attribute_id AND eav_varchar.entity_id = cpe.entity_id
            WHERE
                (eav_int.value IS NOT NULL OR eav_varchar.value IS NOT NULL);
            <br><br>";

            echo "Magento Query : <br><br>";
            echo '$collection = Mage::getResourceModel("catalog/product_collection")
            ->addAttributeToSelect("sku");

        $attributes = Mage::getResourceModel("catalog/product_attribute_collection")
            ->addFieldToFilter("is_user_defined", 1)
            ->getItems();

        foreach ($attributes as $attribute) {
            $attributeCodes[] = $attribute->getAttributeCode();
        }

        $unassignedAttributes = array();

        $products = Mage::getModel("catalog/product")->getCollection()
            ->addAttributeToSelect("sku");


        foreach ($products as $product) {
            $productId = $product->getId();
            $sku = $product->getSku();

            foreach ($attributeCodes as $attributeCode) {
                $attribute = Mage::getSingleton("eav/config")->getAttribute("catalog_product", $attributeCode);
                $attributeId = $attribute->getId();
                $value = $attribute->getSource()->getOptionText($product->getData($attributeCode));

                $resource = Mage::getResourceModel("catalog/product");
                $value = $resource->getAttributeRawValue($productId, $attributeCode, Mage::app()->getStore());

                if ($value) {
                    $unassignedAttributes[] = array(
                        "product_id" => $productId,
                        "sku" => $sku,
                        "attribute_id" => $attributeId,
                        "attribute_code" => $attributeCode,
                        "value" => $value
                    );
                }
            }
        }

        $collection = new Varien_Data_Collection();

        foreach ($unassignedAttributes as $data) {
            $item = new Varien_Object($data);
            $collection->addItem($item);
        }';

        }catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        
    }

}