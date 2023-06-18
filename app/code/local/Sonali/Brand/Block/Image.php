<?php

class Sonali_Brand_Block_Image extends Mage_Core_Block_Template
{
    function __construct()
    {
        parent::__construct();
    }

    public function getRewriteKey($brand)
    {
        $requestPath = strtolower(str_replace(" ", "-", $brand->getData('name'))).'.html';
        return $requestPath;
    }

    public function getBrands()
    {
        $brands = Mage::getModel('brand/brand')->getCollection();
        $brands->addFieldToFilter('status',1);
        $brands->setOrder('sort_order', 'ASC');
        return $brands;
    }

    public function getBrand()
    {
        $brandId = $this->getRequest()->getParam('brand_id');
        $brand = Mage::getModel('brand/brand')->load($brandId);
        return $brand;
    }

    public function getProducts($brand)
    {
        $products = Mage::getModel('catalog/product')->getCollection();
        $products->addAttributeToFilter('brand',$brand->getId());
        return $products;
    }

    public function getProductsByBrand()
    {
        if ($this->getRequest()->getParam('cat')) 
        {
            $category = '*';
        }
        $category = $this->getRequest()->getParam('cat');
        $brandAttributeCode = 'brand'; // Replace with your brand attribute code
        $brandAttribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $brandAttributeCode);


        // $categoryAttributeCode = 'category'; // Replace with your brand attribute code
        // $categoryAttribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $categoryAttributeCode);

        $productCollection = Mage::getModel('catalog/product')->load($category);


        $brandValue = $this->getRequest()->getParam('brand_id'); // Replace with your desired brand attribute value (integer)
        $productCollection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter($brandAttributeCode, $brandValue)
            // ->addAttributeToFilter($categoryAttributeCode, $category)
            ->getAllIds();
        // echo "<pre>";
        

        $products = Mage::getModel('catalog/product')->getCollection()
            ->addIdFilter($productCollection)
            ->addCategoryFilter(Mage::getModel('catalog/category')->load($category))
             // ->addAttributeToFilter('category_id', $category)
            // ->addCategoryFilter($category)
            ->addAttributeToSelect('*');

        // print_r($products);die;
        return $products;
    }


    // public function getProductUrl($product)
    // {
    //     $rewriteCollection = Mage::getModel('core/url_rewrite')->getCollection()
    //         ->addFieldToFilter('product_id', array('in' => $productIds))
    //         ->addFieldToFilter('is_system', 1);
    // }

    public function getProductUrl($product)
    {
        $productId = $product->getId(); 
        $rewrite = Mage::getModel('core/url_rewrite')->load($productId,'product_id');
        $requestPath = $rewrite->getRequestPath();
        return $requestPath;
    }

    public function getCategory()
    {
        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('*')
            ->addFieldToFilter('level', 2)
            ->addIsActiveFilter();

        return $categories;
    }
}
