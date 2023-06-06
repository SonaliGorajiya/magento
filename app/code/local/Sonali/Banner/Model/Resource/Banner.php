<?php
class Sonali_Banner_Model_Resource_Banner extends Mage_Core_Model_Resource_Db_Abstract
{
    function _construct()
    {
        $this->_init('banner/banner', 'banner_id');
    }
}