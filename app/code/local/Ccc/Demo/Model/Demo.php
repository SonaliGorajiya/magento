<?php 

/**
 * 
 */
class Ccc_Demo_Model_Demo extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {  
        $this->_init('eav_attribute/eav_attribute');
    }  

    public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;

        return $this;
    }

    // public function getResourceCollection()
    // {
    //     if (empty($this->_resourceCollectionName)) {
    //         Mage::throwException(Mage::helper('demo')->__('The model collection resource name is not defined.'));
    //     }
    //     $collection = Mage::getResourceModel($this->_resourceCollectionName);
    //     $collection->setStoreId($this->getStoreId());
    //     return $collection;
    // }
}