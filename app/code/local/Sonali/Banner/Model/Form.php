<?php
class Sonali_Banner_Model_Form extends Mage_Eav_Model_Form
{
    protected $_moduleName = 'banner';
    protected $_entityTypeCode = 'banner';

    protected function _getFormAttributeCollection()
    {
        return parent::_getFormAttributeCollection()
            ->addFieldToFilter('attribute_code', array('neq' => 'created_at'));
    }
}
