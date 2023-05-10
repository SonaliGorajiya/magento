<?php

class Ccc_Vendor_Model_Resource_Vendor_Address extends Mage_Core_Model_Resource_Db_Abstract
{
    protected $primatyKey = 'vendor_id';

    protected function _construct()
    {  
        $this->_init('vendor/vendor_address', $this->primatyKey);
    }  

    public function setPrimaryKey($primatyKey)
    {
        $this->primatyKey = $primatyKey;
        $this->_init('vendor/vendor_address', $primatyKey);
        return $this;
    }
}