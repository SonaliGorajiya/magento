<?php 

/**
 * 
 */
class Ccc_Salesman_Model_Salesman extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {  
        $this->_init('salesman/salesman');
    }  

    public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;

        return $this;
    }
}