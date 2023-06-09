<?php
class Sonali_Brand_Model_Resource_Brand extends Mage_Core_Model_Resource_Db_Abstract
{
    function _construct()
    {
        $this->_init('brand/brand', 'brand_id');
    }
}