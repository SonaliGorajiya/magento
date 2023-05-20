<?php
class Sonali_Sonali_Model_Form extends Mage_Eav_Model_Form
{
    protected $_moduleName = 'sonali';
    protected $_entityTypeCode = 'sonali';

    protected function _getFormAttributeCollection()
    {
        return parent::_getFormAttributeCollection()
            ->addFieldToFilter('attribute_code', array('neq' => 'created_at'));
    }
}
