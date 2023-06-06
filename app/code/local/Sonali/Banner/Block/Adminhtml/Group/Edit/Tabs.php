<?php
class Sonali_Banner_Block_Adminhtml_Group_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('banner')->__('Banner Group Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('group_section', array(
            'label' => Mage::helper('banner')->__('Banner Group Information'),
            'title' => Mage::helper('banner')->__('Banner Group Information'),
            'content' => $this->getLayout()->createBlock('banner/adminhtml_group_edit_tab_form')->toHtml(),
        ));

        if (Mage::getModel('banner/group')->getCollection()->getData()) {
            $product = new Mage_Catalog_Model_Product();
            $product->load(1);
            $attributes = $product->getAttributes(10, true);
            $group = new Mage_Eav_Model_Entity_Attribute_Group();
            $group->load(10);
            $this->addTab('banner_section', array(
                'label'     => Mage::helper('catalog')->__('Banners'),
                'content'   => $this->getLayout()->createBlock('banner/adminhtml_group_edit_tab_banner',
                    'banner.adminhtml.group.edit.tab.banner')->setGroup($group)
                        ->setGroupAttributes($attributes)
                        ->toHtml()
            ));
        }

        return parent::_beforeToHtml();
    }
}