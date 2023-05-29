<?php 
class Sonali_Sonali_Block_Adminhtml_Sonali extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'sonali';
		$this->_controller = 'adminhtml_sonali';
		$this->_headerText = $this->__('Sonali Grid');
		$this->_addButtonLabel = $this->__('Add Sonali');
		parent::__construct();
	}
}