<?php
class Sonali_Idx_Model_Resource_Idx_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('idx/idx');
    }
}