<?php

class Sonali_Collection_Block_Adminhtml_Collection extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        
        $this->_blockGroup = 'collection';
        $this->_controller = 'adminhtml_collection';
        $this->_headerText = Mage::helper('collection')->__('Manage Collections');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('collection')->__('Add New Collection'));
        } else {
            $this->_removeButton('add');
        }

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('collection/adminhtml_collection/' . $action);
    }

}