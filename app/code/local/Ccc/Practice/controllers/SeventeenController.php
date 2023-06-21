<?php

class Ccc_Practice_SeventeenController extends Mage_Core_Controller_Front_Action
{
    

    public function indexAction()
    {
        $block = $this->getLayout()->createBlock('practice/adminhtml_practice');
        print_r($block);

    }


}
