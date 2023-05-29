<?php

class Sonali_Idx_Block_Adminhtml_Idx_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('idx')->__('Idx Information'));
    }
    
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('idx')->__('Idx'),
            'title' => Mage::helper('idx')->__('Idx Information'),
            'content' => $this->getLayout()->createBlock('idx/adminhtml_idx_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}





    