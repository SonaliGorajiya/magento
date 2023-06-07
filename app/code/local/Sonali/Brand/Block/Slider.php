<?php
 
class Sonali_Brand_Block_Slider extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getBrands()
    {
        $brands = Mage::getModel('brand/brand')->getCollection();
        return $brands;
    }
}