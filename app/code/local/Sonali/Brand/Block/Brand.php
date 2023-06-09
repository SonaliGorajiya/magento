<?php
class Sonali_Brand_Block_Brand extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCollection()
    {
        return Mage::getModel('brand/brand')->getCollection()->addOrder('sort_order', 'ASC');
    }

    public function getBrands()
    {
        return Mage::getModel('brand/brand')->getCollection()->addFieldToFilter('brand_id', $this->getRequest()->getParam('id'));
    }

    public function getProducts()
    {
        if ($this->getRequest()->getParam('cat')) 
        {
            $category = '*';
        }
        
        $category = $this->getRequest()->getParam('cat');
        $brandAttributeCode = 'brand';
        $brandAttribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $brandAttributeCode);

        $productCollection = Mage::getModel('catalog/product')->load($category);
        $brandValue = $this->getRequest()->getParam('id'); 
        $productCollection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter($brandAttributeCode, $brandValue)
            ->getAllIds();

        $products = Mage::getModel('catalog/product')->getCollection()
            ->addIdFilter($productCollection)
            ->addCategoryFilter(Mage::getModel('catalog/category')->load($category))
            ->addAttributeToSelect('*');

        return $products;
    }

    public function getCategory()
    {
        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addIsActiveFilter();

        return $categories;
    }
}