<?php

class Sg_Vendor_Model_Vendor extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {
        $this->_init('vendor/vendor');
    }

    public function setPasswordConfirmation($passwordConfirmation)
    {
        $this->_getData('password_confirmation', $passwordConfirmation);
        return $this;
    }

    public function setForceConfirmed($forceConfirmed)
    {
        $this->_getData('force_confirmed', $forceConfirmed);
        return $this;
    }
    
}