<?php

class Sonali_Banner_Block_Adminhtml_Banner extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        
        $this->_blockGroup = 'banner';
        $this->_controller = 'adminhtml_banner';
        $this->_headerText = Mage::helper('banner')->__('Manage Banners');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('banner')->__('Add New Banner'));
        } else {
            $this->_removeButton('add');
        }

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('banner/adminhtml_banner/' . $action);
    }

}