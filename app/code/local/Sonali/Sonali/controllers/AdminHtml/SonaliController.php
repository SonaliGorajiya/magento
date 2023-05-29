<?php 

class Sonali_Sonali_Adminhtml_SonaliController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction(){
        $this->loadLayout();
        $this->_setActiveMenu('sonali');
        $this->_title('Sonali Grid');
        $this->_addContent($this->getLayout()->createBlock('sonali/adminhtml_sonali'));
        $this->renderLayout();
    }

    protected function _initSonali()
    {
        $this->_title($this->__('Sonali'))
            ->_title($this->__('Manage Sonalis'));

        $sonaliId = (int) $this->getRequest()->getParam('id');
        $sonali   = Mage::getModel('sonali/sonali')
            ->setStoreId($this->getRequest()->getParam('store', 0))
            ->load($sonaliId);

        if (!$sonaliId) {
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $sonali->setAttributeSetId($setId);
            }
        }

        Mage::register('current_sonali', $sonali);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $sonali;
    }

    public function newAction(){
        $this->_forward('edit');
    }

    public function editAction(){ 
        $sonaliId = (int) $this->getRequest()->getParam('id');
        $sonali   = $this->_initSonali();
        
        if ($sonaliId && !$sonali->getId()) {
            $this->_getSession()->addError(Mage::helper('sonali')->__('This sonali no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($sonali->getName());

        $this->loadLayout();

        $this->_setActiveMenu('sonali/sonali');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->renderLayout();
    }

    public function saveAction()
    {
        try {
            $setId = (int) $this->getRequest()->getParam('set');
            $sonaliData = $this->getRequest()->getPost('account');            
            $sonali = Mage::getSingleton('sonali/sonali');
            $sonali->setAttributeSetId($setId);

            if ($sonaliId = $this->getRequest()->getParam('id')) {
                if (!$sonali->load($sonaliId)) {
                    throw new Exception("No Row Found");
                }
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
            }
            
            $sonali->addData($sonaliData);

            $sonali->save();

            Mage::getSingleton('core/session')->addSuccess("sonali data added.");
            $this->_redirect('*/*/');

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction()
    {
        try {

            $sonaliModel = Mage::getModel('sonali/sonali');

            if (!($sonaliId = (int) $this->getRequest()->getParam('id')))
                throw new Exception('Id not found');

            if (!$sonaliModel->load($sonaliId)) {
                throw new Exception('sonali does not exist');
            }

            if (!$sonaliModel->delete()) {
                throw new Exception('Error in delete record', 1);
            }

            Mage::getSingleton('core/session')->addSuccess($this->__('The sonali has been deleted.'));

        } catch (Exception $e) {
            Mage::logException($e);
            $Mage::getSingleton('core/session')->addError($e->getMessage());
        }
        
        $this->_redirect('*/*/');
    }
}
