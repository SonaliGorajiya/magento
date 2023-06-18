<?php 

class Sg_Vendor_AccountController extends Mage_Core_Controller_Front_Action
{
    public function createAction()
    {
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*');
            return;
        }

        $this->loadLayout();
        $this->renderLayout();
    }

    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }

    public function createpostAction()
    {
        $vendorData = $this->getRequest()->getPost();
        $model = Mage::getModel('vendor/vendor');
        $model->setData($vendorData);
        $model->password = md5($model->password);

        $model->save();
    }
}