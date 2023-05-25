<?php

class Sonali_Sonali_Model_Attribute extends Mage_Eav_Model_Attribute
{
    const MODULE_NAME = 'Sonali_Sonali';
    protected $_eventObject = 'attribute';

    protected function _construct()
    {
        $this->_init('sonali/attribute');
    }
}