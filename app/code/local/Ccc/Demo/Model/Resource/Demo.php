<?php

class Ccc_Demo_Model_Resource_Demo extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {  
        $this->_init('eav_attribute/eav_attribute','attribute_id');
    }  
}