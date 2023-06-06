<?php

class Sonali_Banner_Block_Adminhtml_Banner_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('banner')->__('Banner Information'));
    }
    
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('banner')->__('Banner'),
            'title' => Mage::helper('banner')->__('Banner Information'),
            'content' => $this->getLayout()->createBlock('banner/adminhtml_banner_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}





    