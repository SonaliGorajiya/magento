<?php
class Sonali_Banner_Model_Source_Model extends Mage_Eav_Model_Entity_Attribute_Source_Abstract implements Mage_Eav_Model_Entity_Attribute_Source_Interface
{
    public function getAllOptions()
    {
        $banner = Mage::getModel('banner/banner')->getCollection()->getItems();
        $arr = array();
        foreach ($banner as $k=>$v) {
            $arr[] = array('value'=>$k, 'label'=>$v->name);
        }
        return $arr;
    }
}