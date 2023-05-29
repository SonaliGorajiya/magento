<?php

class Sonali_Collection_Model_Resource_Collection extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {  
        $this->_init('collection/collection', 'collection_id');
    }  
}