<?php

class Ccc_Practice_Block_Adminhtml_Practice_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('practice')->__('Practice Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('practice_section', array(
        'label' => Mage::helper('practice')->__('Practice Information'),
        'title' => Mage::helper('practice')->__('Practice Information'),
        'content' => $this->getLayout()->createBlock('practice/adminhtml_practice_edit_tab_practice')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
