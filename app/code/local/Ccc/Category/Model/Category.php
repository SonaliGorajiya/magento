<?php 

/**
 * 
 */
class Ccc_Category_Model_Category extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {  
        $this->_init('category/category');
    }  

    public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;

        return $this;
    }
}