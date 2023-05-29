<?php
class Sonali_Sonali_Model_Resource_Sonali_Collection extends Mage_Catalog_Model_Resource_Collection_Abstract
{
	public function __construct()
	{
		$this->setEntity('sonali');
		parent::__construct();	
	}
}