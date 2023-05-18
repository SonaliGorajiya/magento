<?php

class Sonali_Sonali_Model_Resource_Sonali extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {  
        $this->_init('sonali/sonali', 'sonali_id');
    }  
}