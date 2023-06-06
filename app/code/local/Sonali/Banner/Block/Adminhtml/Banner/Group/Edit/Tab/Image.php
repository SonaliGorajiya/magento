<?php

class Sonali_Banner_Block_Adminhtml_Banner_Group_Edit_Tab_Image extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->setTemplate('banner/group/gallery.phtml');
    }

    public function getBannerCollection()
    {
        $collection = Mage::getModel('banner/banner')->getCollection()->addFieldToFilter('group_id',$this->getRequest()->getParam('group_id'));
        return $collection;
    }
}