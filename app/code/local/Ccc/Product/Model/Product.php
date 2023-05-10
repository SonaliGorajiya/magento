<?php 

/**
 * 
 */
class Ccc_Product_Model_Product extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {  
        $this->_init('product/product');
    }  

    public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;

        return $this;
    }
}