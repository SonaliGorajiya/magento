<?php

class Sonali_Sonali_Block_Adminhtml_Attribute_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('sonali_attribute_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('sonali')->__('Attribute Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('main', array(
            'label'     => Mage::helper('sonali')->__('Properties'),
            'title'     => Mage::helper('sonali')->__('Properties'),
            'content'   => $this->getLayout()->createBlock('sonali/adminhtml_attribute_edit_tab_main')->toHtml(),
            'active'    => true
        ));

        $model = Mage::registry('entity_attribute');

        $this->addTab('labels', array(
            'label'     => Mage::helper('sonali')->__('Manage Label / Options'),
            'title'     => Mage::helper('sonali')->__('Manage Label / Options'),
            'content'   => $this->getLayout()->createBlock('sonali/adminhtml_attribute_edit_tab_options')->toHtml(),
        ));
        
        /*if ('select' == $model->getFrontendInput()) {
            $this->addTab('options_section', array(
                'label'     => Mage::helper('sonali')->__('Options Control'),
                'title'     => Mage::helper('sonali')->__('Options Control'),
                'content'   => $this->getLayout()->createBlock('adminhtml/sonali_product_attribute_edit_tab_options')->toHtml(),
            ));
        }*/

        return parent::_beforeToHtml();
    }

}
