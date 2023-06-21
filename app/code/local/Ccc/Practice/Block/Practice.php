<?php

class Ccc_Practice_Block_Practice extends Mage_Core_Block_Template
{
    function __construct()
    {
        parent::__construct();
        $this->setTemplate('practice/home.phtml');
    }

    public function getoneUrl()
    {
        return $this->getUrl('*/adminhtml_query/one');
    }
}
