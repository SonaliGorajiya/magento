<?php

class Sonali_Sonali_Block_Adminhtml_Sonali_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('sonali')->__('Sonali Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('sonali_section', array(
        'label' => Mage::helper('sonali')->__('Sonali Information'),
        'title' => Mage::helper('sonali')->__('Sonali Information'),
        'content' => $this->getLayout()->createBlock('sonali/adminhtml_sonali_edit_tab_sonali')->toHtml(),
        ));

        /*$this->addTab('address_section', array(
        'label' => Mage::helper('sonali')->__('Sonali Address Information'),
        'title' => Mage::helper('sonali')->__('Sonali Address Information'),
        'content' => $this->getLayout()->createBlock('sonali/adminhtml_sonali_edit_tab_address')->toHtml(),
        ));

        if ($this->getRequest()->getParam('id')) {
            $this->addTab('sonali_price_section', array(
            'label' => Mage::helper('sonali')->__('Sonali Price Information'),
            'title' => Mage::helper('sonali')->__('Sonali Price Information'),
            'content' => $this->getLayout()->createBlock('sonali/adminhtml_sonali_edit_tab_price')->toHtml(),
            ));
        }*/
        
        return parent::_beforeToHtml();
    }
}
