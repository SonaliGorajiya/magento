<?php

class Sonali_Banner_Block_Banner extends Mage_Core_Block_Template
{
    function __construct()
    {
        parent::__construct();
        $this->setTemplate('banner/slider.phtml');
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->randerLayout();
    }

    public function getSliderData()
    {
        $collection = Mage::getModel('banner/banner')->getCollection();
        return $collection;
    }
}
