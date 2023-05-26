<?php

class Ccc_Salesman_Block_Adminhtml_Salesman_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('salesman')->__('Salesman Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('salesman_section', array(
        'label' => Mage::helper('salesman')->__('Salesman Information'),
        'title' => Mage::helper('salesman')->__('Salesman Information'),
        'content' => $this->getLayout()->createBlock('salesman/adminhtml_salesman_edit_tab_salesman')->toHtml(),
        ));

        $this->addTab('address_section', array(
        'label' => Mage::helper('salesman')->__('salesman Address Information'),
        'title' => Mage::helper('salesman')->__('salesman Address Information'),
        'content' => $this->getLayout()->createBlock('salesman/adminhtml_salesman_edit_tab_address')->toHtml(),
        ));

        if ($this->getRequest()->getParam('id')) {
            $this->addTab('salesman_price_section', array(
            'label' => Mage::helper('salesman')->__('Salesman Price Information'),
            'title' => Mage::helper('salesman')->__('Salesman Price Information'),
            'content' => $this->getLayout()->createBlock('salesman/adminhtml_salesman_edit_tab_price')->toHtml(),
            ));
        }
        
        return parent::_beforeToHtml();
    }
}
