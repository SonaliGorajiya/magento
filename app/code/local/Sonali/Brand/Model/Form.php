<?php
class Sonali_Brand_Model_Form extends Mage_Eav_Model_Form
{
    protected $_moduleName = 'brand';
    protected $_entityTypeCode = 'brand';

    protected function _getFormAttributeCollection()
    {
        return parent::_getFormAttributeCollection()
            ->addFieldToFilter('attribute_code', array('neq' => 'created_at'));
    }
}
