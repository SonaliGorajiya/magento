<?php

class Ccc_Salesman_Model_Resource_Salesman_Price extends Mage_Core_Model_Resource_Db_Abstract
{
    protected $primatyKey = 'entity_id';

    protected function _construct()
    {  
        $this->_init('salesman/salesman_price', $this->primatyKey);
    }  

    public function setPrimaryKey($primatyKey)
    {
        $this->primatyKey = $primatyKey;
        $this->_init('salesman/salesman_price', $primatyKey);
        return $this;
    }
}