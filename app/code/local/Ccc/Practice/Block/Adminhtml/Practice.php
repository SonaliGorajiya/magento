<?php

class Ccc_Practice_Block_Adminhtml_Practice extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'practice';
        $this->_controller = 'adminhtml_index';
        $this->setTemplate('practice/index.phtml');
        parent::__construct();
        $this->_removeButton('add');
    }


}