<?php

class Sonali_Idx_Block_Adminhtml_Idx extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        
        $this->_blockGroup = 'idx';
        $this->_controller = 'adminhtml_idx';
        $this->_headerText = Mage::helper('idx')->__('Manage Idxs');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('idx')->__('Add New Idx'));
        } else {
            $this->_removeButton('add');
        }
        $this->_addButton('idx_idx', array(
        'label' => $this->__('Export Sample Csv'),
        'onclick' => "setLocation('{$this->getUrl('*/*/download')}')",
    ));
        $this->_headerText = $this->__('Import Products');
        $this->_addButton('brand', array(
            'label'     => Mage::helper('idx')->__('Brand'),
            'onclick'   => "setLocation('{$this->getUrl('*/*/brand')}')",
        ));

        $this->_addButton('collection', array(
            'label'     => Mage::helper('idx')->__('Collection'),
            'onclick'   => "setLocation('{$this->getUrl('*/*/collection')}')",
        ));

        $this->_addButton('product', array(
            'label'     => Mage::helper('idx')->__('Product'),
            'onclick'   => "setLocation('{$this->getUrl('*/*/product')}')",
        ));
        $this->_removeButton('reset');
        $this->_removeButton('delete');
        $this->_removeButton('save');

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('idx/adminhtml_idx/' . $action);
    }

    protected function _prepareLayout()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'import_form',
            'action'    => $this->getUrl('*/*/import'),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $form->addField('csv_file', 'file', array(
            'name'      => 'csv_file',
            'label'     => $this->__('CSV File'),
            'title'     => $this->__('CSV File'),
            'required'  => true,
        ));

        $this->setForm($form);
        return parent::_prepareLayout();
    }

}