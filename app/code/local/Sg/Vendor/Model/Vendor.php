<?php 

/**
 * 
 */
class Sg_Vendor_Model_Vendor extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {  
        $this->_init('vendor/vendor');
    }  

    public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;

        return $this;
    }

    public function getStatuses()
    {
        return [
            '1' => 'Active',
            '0' => 'Non Active'
        ]; 
    }

    public function setPassword($password)
    {
        $this->setData('password', md5($password));
        return $this;
    }
}