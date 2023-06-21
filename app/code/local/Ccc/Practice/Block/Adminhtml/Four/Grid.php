<?php

class Ccc_Practice_Block_Adminhtml_Four_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $products->addAttributeToSelect(array('name','sku','image','small_image','thumbnail'));
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

        $this->addColumn('base_image', array(
            'header'    => Mage::helper('practice')->__('Base Image'),
            'align'     => 'left',
            'index'     => 'image',
            'renderer'  =>'Ccc_Practice_Block_Adminhtml_Four_Renderer_Image'
        ));

        $this->addColumn('small_image', array(
            'header'    => Mage::helper('practice')->__('Small Image'),
            'align'     => 'left',
            'index'     => 'small_image',
            'renderer'  =>'Ccc_Practice_Block_Adminhtml_Four_Renderer_Smallimage'
        ));

        $this->addColumn('thumb_image', array(
            'header'    => Mage::helper('practice')->__('Thumb Image'),
            'align'     => 'left',
            'index'     => 'thumbnail',
            'renderer'  =>'Ccc_Practice_Block_Adminhtml_Four_Renderer_Thumbnail'
        ));

        return parent::_prepareColumns();
    }
    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('category_id' => $row->getId()));
    }
   
}