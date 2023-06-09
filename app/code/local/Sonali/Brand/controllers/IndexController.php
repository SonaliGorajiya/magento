<?php
class Sonali_Brand_IndexController extends Mage_Core_Controller_Front_Action
{
    public function productAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}