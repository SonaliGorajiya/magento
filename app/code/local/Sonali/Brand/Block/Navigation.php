<?php

class Sonali_Brand_Block_Navigation extends Mage_Core_Block_Template
{
    public function getCategories()
    {
        $categories = Mage::getModel('catalog/category')->getCollection()
        ->addAttributeToSelect('*')
        ->addAttributeToFilter('is_active', 1);        
        return $categories;
    }
}