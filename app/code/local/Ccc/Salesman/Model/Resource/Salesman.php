<?php

class Ccc_Salesman_Model_Resource_Salesman extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {  
        $this->_init('salesman/salesman', 'salesman_id');
    }  
}