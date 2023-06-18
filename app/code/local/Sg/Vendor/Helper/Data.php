<?php  

class Sg_Vendor_Helper_Data extends Mage_Core_Helper_Abstract
{
    const ROUTE_ACCOUNT_LOGIN = 'vendor/account/login';
    const REFERER_QUERY_PARAM_NAME = 'referer';
    const XML_PATH_CUSTOMER_STARTUP_REDIRECT_TO_DASHBOARD = 'vendor/startup/redirect_dashboard';

    public function getRegisterPostUrl()
    {
        return $this->_getUrl('vendor/account/createpost');
    }

    public function getLoginUrl()
    {
        return $this->_getUrl(self::ROUTE_ACCOUNT_LOGIN, $this->getLoginUrlParams());
    }

    public function getLoginUrlParams()
    {
        $params = array();

        $referer = $this->_getRequest()->getParam(self::REFERER_QUERY_PARAM_NAME);

        if (!$referer && !Mage::getStoreConfigFlag(self::XML_PATH_CUSTOMER_STARTUP_REDIRECT_TO_DASHBOARD)
            && !Mage::getSingleton('customer/session')->getNoReferer()
        ) {
            $referer = Mage::getUrl('*/*/*', array('_current' => true, '_use_rewrite' => true));
            $referer = Mage::helper('core')->urlEncode($referer);
        }

        if ($referer) {
            $params = array(self::REFERER_QUERY_PARAM_NAME => $referer);
        }

        return $params;
    }
}

?>