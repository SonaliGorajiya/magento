<?php
class Sonali_Idx_Model_Resource_Idx extends Mage_Core_Model_Resource_Db_Abstract
{
    function _construct()
    {
        $this->_init('idx/idx', 'index');
    }
}