<?php

class Sonali_Sonali_Adminhtml_AttributeController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    { 
        $this->_title($this->__('Manage Attributes'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('sonali/adminhtml_attribute'));
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        echo "this is edit action";
    }
}
