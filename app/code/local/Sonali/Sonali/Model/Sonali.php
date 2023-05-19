<?php 

/**
 * 
 */
class Sonali_Sonali_Model_Sonali extends Mage_Core_Model_Abstract
{
    protected $_attributes;
    const ENTITY = 'sonali';
	protected function _construct()
    {  
        $this->_init('sonali/sonali');
    }  

    public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;

        return $this;
    }
}