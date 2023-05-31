<?php
class Sonali_Idx_Model_Idx extends Mage_Core_Model_Abstract
{
	function __construct()
	{
		$this->_init('idx/idx');
	}

    public function truncate()
    {
        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $tableName = $resource->getTableName('import_product_idx');
        return $writeConnection->truncateTable($tableName);
    }
    
    public function insertOnDuplicate($data, $fields)
    {
        $resource = Mage::getSingleton('core/resource');
        $connection = $resource->getConnection('core_write');
        $table = $resource->getTableName('import_product_idx');
        return $connection->insertOnDuplicate($table, $data, $fields);
    }
    

    public function updateBrandTable($data)
    {
        $brandCollection = Mage::getModel('brand/brand')->getCollection();
        $brandNames = $brandCollection->getConnection()
            ->fetchPairs($brandCollection->getSelect()->columns(['brand_id','name']));
        $newBrands = array_diff($data, $brandNames);
        foreach ($newBrands as $name) {
            $prepareData[] = ['name'=>$name];
        }
            if($prepareData){
            $resource = Mage::getSingleton('core/resource');
            $tableName = $resource->getTableName('brand');
            $writeConnection = $resource->getConnection('core_write');
            $writeConnection->insertMultiple($tableName, $prepareData);
        }
        return true;
    }

    public function updateCollectionOption($data)
    {
        $resource = Mage::getSingleton('core/resource');
        $writeAdapter = $resource->getConnection('core_write');
        $optionValueTable = $resource->getTableName('eav_attribute_option_value');
        $collectionNames = $writeAdapter->fetchPairs($writeAdapter->select()->from($optionValueTable, ['option_id','value']));
    
        $newCollections = array_diff($data, $collectionNames);
        foreach ($newCollections as $name) {
            $prepareData[] = ['value'=> [0 => $name]];
        }
        
        if($prepareData){
            $this->addAttributeOption('collection', $prepareData);
        }
        return true;
    }

    public function addAttributeOption($attributeCode, $options)
    {
        $attributeId = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', $attributeCode)->getId();

        foreach ($options as $option) {
            $option['attribute_id'] = $attributeId;

            $optionModel = Mage::getModel('eav/entity_attribute_option');
            $optionModel->setData($option)->save();

            $resource = Mage::getSingleton('core/resource');
            $writeAdapter = $resource->getConnection('core_write');
            $optionValueTable = $resource->getTableName('eav_attribute_option_value');
            foreach ($option['value'] as $storeId => $storeValue) {
                $data = array(
                    'option_id' => $optionModel->getId(),
                    'store_id' => $storeId,
                    'value' => $storeValue,
                );
                $writeAdapter->insert($optionValueTable, $data);
            }
        }
    }

    public function query($sql)
    {
        $adapter = Mage::getSingleton('core/resource')->getConnection('core_write');
        return $adapter->query($sql);
    }

    public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;

        return $this;
    }
}