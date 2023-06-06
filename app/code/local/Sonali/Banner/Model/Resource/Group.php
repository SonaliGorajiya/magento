<?php

class Sonali_Banner_Model_Resource_Group extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {  
        $this->_init('banner/group', 'group_id');
    }  
}