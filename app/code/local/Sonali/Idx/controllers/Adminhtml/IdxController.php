<?php
class Sonali_Idx_Adminhtml_IdxController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Idx'))
             ->_title($this->__('Manage Product Idxs'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('idx/adminhtml_idx'));
        $this->renderLayout();
    }

    public function brandAction()
    {
        try {
            Mage::getModel('idx/idx')->updateTableColumn(Mage::getModel('brand/brand'), 'brand');
            Mage::getSingleton('adminhtml/session')->addSuccess('Brand is up to date');
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        
        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        try { 
            $idxIds = $this->getRequest()->getParam('index');
            if(!is_array($idxIds)) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('idx')->__('Please select idx(s).'));
            } else {
                $model = Mage::getModel('idx/idx');
                foreach ($idxIds as $idxId) {
                    $model->load($idxId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('idx/idx')->__(
                    'Total of %d record(s) were deleted.', count($idxIds)
                )
                );
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        $this->_redirect('*/*/index');
    }
}