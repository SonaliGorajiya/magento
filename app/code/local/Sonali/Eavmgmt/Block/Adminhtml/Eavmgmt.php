<?php
class Sonali_Eavmgmt_Block_Adminhtml_Eavmgmt extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'eavmgmt';
        $this->_controller = 'adminhtml_eavmgmt';
        $this->_headerText = Mage::helper('eavmgmt')->__('Manage Eavmgmt Grid');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('eavmgmt')->__('Add New Eavmgmt'));
        } else {
            $this->_removeButton('add');
        }

    }
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('eavmgmt/adminhtml_eavmgmt/' . $action);
    }

}