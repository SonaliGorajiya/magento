<?php
class Sonali_Brand_Model_Source_Model extends Mage_Eav_Model_Entity_Attribute_Source_Abstract implements Mage_Eav_Model_Entity_Attribute_Source_Interface
{
    public function getAllOptions()
    {
        $brand = Mage::getModel('brand/brand')->getCollection()->getItems();
        // $arr = array();
        foreach ($brand as $brand_id=>$brand) {
            $options[] = array('value'=>$brand_id, 'label'=>$brand->name);
        }
        return $options;
    }
}
