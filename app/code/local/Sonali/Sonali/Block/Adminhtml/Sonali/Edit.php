<?php
class Sonali_Sonali_Block_Adminhtml_Sonali_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{	
	public function __construct()
	{		
		$this->_blockGroup = 'sonali';
        $this->_controller = 'adminhtml_sonali';
        $this->_headerText = 'Add Sonali';
        parent::__construct();
        if(!$this->getRequest()->getParam('set') && !$this->getRequest()->getParam('id'))
		{
			$this->_removeButton('save');
		} 
	}
}