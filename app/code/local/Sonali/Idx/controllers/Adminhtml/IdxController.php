<?php

class Sonali_Idx_Adminhtml_IdxController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('idx/idx')
            ->_addBreadcrumb(Mage::helper('idx')->__('Idx Manager'), Mage::helper('idx')->__('Idx Manager'))
            ->_addBreadcrumb(Mage::helper('idx')->__('Manage Idx'), Mage::helper('idx')->__('Manage Idx'))
        ;
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__('Idx'))->_title($this->__('Manage Idx'));
        $this->loadLayout();
        $this->_addContent(
            $this->getLayout()->createBlock('idx/adminhtml_idx', 'idx')
        );
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

}