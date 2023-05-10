<?php

class Ccc_Salesman_Model_Resource_Salesman_Address extends Mage_Core_Model_Resource_Db_Abstract
{
    protected $primatyKey = 'salesman_id';

    protected function _construct()
    {  
        $this->_init('salesman/salesman_address', $this->primatyKey);
    }  

    public function setPrimaryKey($primatyKey)
    {
        $this->primatyKey = $primatyKey;
        $this->_init('salesman/salesman_address', $primatyKey);
        return $this;
    }
}