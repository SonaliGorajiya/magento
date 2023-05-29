<?php

class Sonali_Eavmgmt_Model_Resource_Eavmgmt_Collection extends Mage_Eav_Model_Resource_Entity_Attribute_Collection
{
    
    protected function _initSelect()
    {
        // $entityTypeId = (int)Mage::getModel('eav/entity')->setType(Mage_Catalog_Model_Product::ENTITY)->getTypeId();
        $columns = $this->getConnection()->describeTable($this->getResource()->getMainTable());
        $retColumns = array();
        foreach ($columns as $labelColumn => $columnData) {
            $retColumns[$labelColumn] = $labelColumn;
            if ($columnData['DATA_TYPE'] == Varien_Db_Ddl_Table::TYPE_TEXT) {
                $retColumns[$labelColumn] = Mage::getResourceHelper('core')->castField('main_table.'.$labelColumn);
            }
        }
        // $this->getSelect()
        //     ->from(array('main_table' => $this->getResource()->getMainTable()), $retColumns)
        //     ->join(
        //         array('additional_table' => $this->getTable('catalog/eav_attribute')),
        //         // array('additional_table' => 'eav_attribute'),
        //         'additional_table.attribute_id = main_table.attribute_id'
        //         );
            // ->where('main_table.entity_type_id = ?', $entityTypeId);


         $this->getSelect()
            ->from(array('main_table' => $this->getResource()->getMainTable()), $retColumns)
            ->join(
                array('eet' => 'eav_entity_type'),
                'eet.entity_type_id = main_table.entity_type_id'
                );
        return $this;
    }
}
