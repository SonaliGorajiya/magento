<?php

class Sonali_Banner_Model_SourceModel
{

    protected $collection = null;

    public function toOptionArray()
    {
        $options = array();

        // Fetch data from your table and populate the options array
        $collection = Mage::getModel('banner/group')->getCollection();
        foreach ($collection as $item) {
            $options[] = array(
                'value' => $item->getId(),
                'label' => $item->getName()
            );
        }

        return $options;
    }
}
