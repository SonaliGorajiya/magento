<?php

class Sonali_Banner_Block_Adminhtml_Banner_Group_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        if ($this->getRequest()->getParam('group_id')) {
            $this->addTab('form_section', array(
                'label' => Mage::helper('banner')->__('Banner Group'),
                'title' => Mage::helper('banner')->__('Banner Group Information'),
                'content' => $this->getLayout()->createBlock('banner/adminhtml_banner_group_edit_tab_form')->toHtml(),
            ));

            $this->addTab('group_10', array(
                'label'     => Mage::helper('banner')->__('Banners'),
                'content'   => $this->getLayout()->createBlock('banner/adminhtml_banner_group_edit_tab_image')
                        ->toHtml()
            ));

        }

        $this->addTab('form_section', array(
            'label' => Mage::helper('banner')->__('Banner Group'),
            'title' => Mage::helper('banner')->__('Banner Group Information'),
            'content' => $this->getLayout()->createBlock('banner/adminhtml_banner_group_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}





    