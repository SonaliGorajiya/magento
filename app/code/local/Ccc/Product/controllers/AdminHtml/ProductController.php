<?php

class Ccc_Product_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('product/manage');
    }

    public function preDispatch()
    {
        $this->_setForcedFormKeyActions(array('delete', 'massDelete'));
        return parent::preDispatch();
    }

    public function indexAction()
    {
        
        $this->loadLayout();
        $this->_setActiveMenu('product/manage');
        $this->_title($this->__("Product Grid"));
        $this->_addContent($this->getLayout()->createBlock('product/adminhtml_product'));
        $this->renderLayout();
    }


    public function newAction() {
        $this->_forward('edit');
    }   

    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        if (!$model = Mage::getModel('product/product')->load($id)){
            $model = Mage::getModel('product/product');
        }

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('product_data', $model);
        $this->loadLayout();
        $this->_setActiveMenu('product/items');
        $this->_addContent($this->getLayout()->createBlock(' product/adminhtml_product_edit'))
            ->_addLeft($this->getLayout()->createBlock('product/adminhtml_product_edit_tabs'));
        $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('product')->__('Product does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        if ($this->getRequest()->getParam('back')) {
            $this->_redirect('*/*/edit', array('id' => $model->getId()));
            return;
        }

        if ($data = $this->getRequest()->getPost()) {
            $product = $data['product'];
            $model = Mage::getModel('product/product');
            $model->setData($product)->setId($this->getRequest()->getParam('id'));
            try {
                if ($model->product_id != null) {
                    $model->updated_at = date('Y-m-d H:i:s');
                } else {
                    $model->created_at = date('Y-m-d H:i:s');
                }
                
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('product')->__('Product was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                 
                if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($product);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('product')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }


    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('product/product');
                 
                $model->setId($this->getRequest()->getParam('id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Product was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function exportCsvAction()
    {
        $fileName   = 'products.csv';
        $content    = $this->getLayout()->createBlock('product/adminhtml_product_grid')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'products.xml';
        $content    = $this->getLayout()->createBlock('product/adminhtml_product_grid')
            ->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }


    public function massDeleteAction()
    {
        $productIDs = $this->getRequest()->getParam('product_id');
        if(!is_array($productIDs)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select product(s).'));
        } else {
            try {
                $product = Mage::getModel('product/product');
                foreach ($productIDs as $productId) {
                    $product->reset()
                        ->load($productId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($productIDs))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

}