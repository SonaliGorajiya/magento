<?php 

class Sonali_Banner_BannerController extends Mage_Core_Controller_Front_Action
{
	public function indexAction(){
		$this->loadLayout();
		$this->_title('Banner Grid');
		$this->renderLayout();
	}

}