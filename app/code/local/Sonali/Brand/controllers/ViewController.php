<?php

class Sonali_Brand_ViewController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        // echo "string";die;
        $this->loadLayout();
        // $this->getLayout()->getBlock('head')->setTitle($this->__('Test'));
        // $block = $this->getLayout()->createBlock('Sonali_Brand_Block_View','test');
        $this->renderLayout();
    }

    public function viewAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
