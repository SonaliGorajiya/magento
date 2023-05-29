<?php
class Sonali_Eavmgmt_Model_Source_Option extends Mage_Eav_Model_Entity_Attribute_Source_Abstract implements Mage_Eav_Model_Entity_Attribute_Source_Interface
{
    public function getAllOptions()
    {
        $eavmgmts = Mage::getModel('eavmgmt/eavmgmt')->getCollection()->getItems();
        $options = array();
        foreach ($eavmgmts as $key=>$eavmgmt) {
            $options[] = array('value'=>$eavmgmt->eavmgmt_id, 'label'=>$eavmgmt->name);

        }
        return $options;
    }
}
