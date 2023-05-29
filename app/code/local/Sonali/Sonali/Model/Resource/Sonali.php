<?php 
class Sonali_Sonali_Model_Resource_Sonali extends Mage_Eav_Model_Entity_Abstract
{
	const ENTITY = 'sonali';
	public function __construct()
	{
		$this->setType(self::ENTITY)
			 ->setConnection('core_read', 'core_write');
	   parent::__construct();
    }
}