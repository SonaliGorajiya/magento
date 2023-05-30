<?php
class Sonali_Idx_Block_Adminhtml_Idx_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        // parent::__construct();
        // $this->setId('index');

        parent::__construct();
         
        $this->setDefaultSort('product_id');
        $this->setId('adminhtmlIdxGrid');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);

    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('idx/idx')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('index', array(
            'header'    => Mage::helper('idx')->__('Id'),
            'width'     => '50px',
            'index'     => 'index',
            'type'  => 'number',
        ));

        $this->addColumn('product_id', array(
            'header'    => Mage::helper('idx')->__('Product id'),
            'index'     => 'product_id'
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('idx')->__('Name'),
            'index'     => 'name'
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('idx')->__('Sku'),
            'index'     => 'sku'
        ));

        $this->addColumn('price', array(
            'header'    => Mage::helper('idx')->__('Price'),
            'index'     => 'price'
        ));

        $this->addColumn('cost', array(
            'header'    => Mage::helper('idx')->__('Cost'),
            'index'     => 'cost'
        ));

        $this->addColumn('quantity', array(
            'header'    => Mage::helper('idx')->__('Quantity'),
            'index'     => 'quantity'
        ));

        $this->addColumn('brand', array(
            'header'    => Mage::helper('idx')->__('Brand'),
            'index'     => 'brand'
        ));

        $this->addColumn('collection', array(
            'header'    => Mage::helper('idx')->__('Collection'),
            'index'     => 'collection'
        ));

        $this->addColumn('description', array(
            'header'    => Mage::helper('idx')->__('Description'),
            'index'     => 'description'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('idx')->__('Status'),
            'index'     => 'status'
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('product_id');
        $this->getMassactionBlock()->setFormFieldName('product_id');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('idx')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('idx')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }
}
