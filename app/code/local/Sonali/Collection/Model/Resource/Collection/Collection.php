<?php
class Sonali_Collection_Model_Resource_Collection_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('collection/collection');
    }
}