<?php

class Ccc_Practice_Block_Adminhtml_Five_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('practiceAdminhtmlPracticeGrid');
        $this->setDefaultSort('attribute_id');
        $this->setDefaultDir('ASC');
    }

     protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('entity_id')
            ->addAttributeToSelect('sku');

        $collection->getSelect()->joinLeft(
            array('mg' => $collection->getTable('catalog/product_attribute_media_gallery')),
            'mg.entity_id = e.entity_id',
            array('gallery_image_count' => 'COUNT(mg.value_id)')
        );

        $collection->getSelect()->group('e.entity_id');

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('product_id', array(
            'header'    => Mage::helper('product')->__('Product Id'),
            'align'     => 'left',
            'index'     => 'entity_id'
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('product')->__('SKU'),
            'align'     => 'left',
            'index'     => 'sku'
        ));

        $this->addColumn('gallery_image_count', array(
            'header'    => Mage::helper('product')->__('Gallery Image Count'),
            'align'     => 'left',
            'index'     => 'gallery_image_count',
        ));


        return parent::_prepareColumns();
    }
}