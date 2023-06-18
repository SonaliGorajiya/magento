<?php

class Sonali_Brand_Block_Adminhtml_Brand_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('brandAdminhtmlBrandGrid');
        $this->setDefaultSort('brand_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('brand/brand')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('brand_id', array(
            'header'    => Mage::helper('brand')->__('Brand Id'),
            'align'     => 'left',
            'index'     => 'brand_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('brand')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('image', array(
            'header'    => Mage::helper('brand')->__('Image'),
            'align'     => 'left',
            'index'     => 'image',
            'renderer'  => 'Sonali_Brand_Block_Adminhtml_Brand_Grid_Renderer_Image'
        ));

        $this->addColumn('brand_banner', array(
            'header'    => Mage::helper('brand')->__('Brand Banner'),
            'align'     => 'left',
            'index'     => 'brand_banner',
            'renderer'=> 'Sonali_Brand_Block_Adminhtml_Brand_Grid_Renderer_Banner',
        ));

        $this->addColumn('sort_order', array(
            'header'    => Mage::helper('brand')->__('Sort Order'),
            'align'     => 'left',
            'index'     => 'sort_order',
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('brand')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
            'renderer'=> 'Sonali_Brand_Block_Adminhtml_Brand_Grid_Renderer_Status',

        ));

        $this->addColumn('description', array(
            'header'    => Mage::helper('brand')->__('Description'),
            'align'     => 'left',
            'index'     => 'description'
        ));

        $this->addColumn('created_time', array(
            'header'    => Mage::helper('brand')->__('Created At'),
            'align'     => 'left',
            'index'     => 'created_time',
        ));

        $this->addColumn('update_time', array(
            'header'    => Mage::helper('brand')->__('Updated At'),
            'align'     => 'left',
            'index'     => 'update_time',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('brand_id' => $row->getId()));
    }
   
}