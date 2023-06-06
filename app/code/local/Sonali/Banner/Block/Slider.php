<?php

class Sonali_Banner_Block_Slider extends Mage_Core_Block_Template
{
    function __construct()
    {
        parent::__construct();
    }

    public function getSliderData()
    {
        $groupId = Mage::getStoreConfig('banner/banner/bannergroup');        
        $collection = Mage::getModel('banner/banner')->getCollection();
        $collection->addFieldToFilter('group_id', $groupId);
        return $collection;
    }
}
