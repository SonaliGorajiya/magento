<?php

class Sonali_Banner_Model_Group extends Mage_Core_Model_Abstract
{
    function __construct()
    {
        $this->_init('banner/group');
    }

    public function getGroups()
    {
        $bannerData = $this->getCollection()->getData();
        $groupId = array_column($bannerData, 'group_id');
        $name = array_column($bannerData, 'name');
        $result = array_combine($groupId, $name);
        return $result; 
    }

    public function getBaseTmpMediaPath()
    {
        return Mage::getBaseDir('media').DS.'tmp'.DS.'banner'.DS.'original';
    }

    public function getTmpMediaUrl($file)
    {
        return Mage::getBaseUrl('media').DS.'tmp'.DS.'banner'.DS.'original'.DS.$file;
    }
}
