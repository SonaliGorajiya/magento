<?php

class Ccc_Practice_Block_Adminhtml_Five_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $products = Mage::getModel('catalog/product')->getCollection();
        $products->addAttributeToSelect(array('sku','media_gallery'));
        $this->setCollection($products);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('product_id', array(
            'header'    => Mage::helper('practice')->__('Product Id'),
            'align'     => 'left',
            'index'     => 'entity_id',
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('practice')->__('SKU'),
            'align'     => 'left',
            'index'     => 'sku',
        ));

        $this->addColumn('gallary_count', array(
            'header'    => Mage::helper('practice')->__('Gallary Images Count'),
            'align'     => 'left',
            'index'     => 'media_gallery',
            'renderer'  =>'Ccc_Practice_Block_Adminhtml_Five_Renderer_Count'
        ));


        return parent::_prepareColumns();
    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('category_id' => $row->getId()));
    }
   
}