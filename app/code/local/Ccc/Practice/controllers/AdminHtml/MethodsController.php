<?php

class Ccc_Practice_Adminhtml_FirstController extends Mage_Core_Controller_Front_Action
{
        public function indexAction()
        {
                echo "<pre>";
                print_r(Mage::getVersionInfo());
                die();
        }
}