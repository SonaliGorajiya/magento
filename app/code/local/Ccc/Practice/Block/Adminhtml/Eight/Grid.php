<?php

class Ccc_Practice_Block_Adminhtml_Eight_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('PracticeAdminhtmlPracticeGrid');
        $this->setDefaultSort('category_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('sales/order_item_collection');

        $collection->getSelect()
            ->columns(array('product_id', 'sku', 'total_qty_ordered' => 'SUM(qty_ordered)'))
            ->group('product_id');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('product_id', array(
            'header'    => Mage::helper('category')->__('Product Id'),
            'align'     => 'left',
            'index'     => 'product_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('category')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('category')->__('SKU'),
            'align'     => 'left',
            'index'     => 'sku',
        ));

        $this->addColumn('sold_quantity', array(
            'header'    => Mage::helper('category')->__('Sold Quantity'),
            'align'     => 'left',
            'index'     => 'total_qty_ordered',
        ));
        return parent::_prepareColumns();
    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('category_id' => $row->getId()));
    }
   
}