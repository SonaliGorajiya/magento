<?php

class Sonali_Banner_Block_Adminhtml_Banner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('bannerAdminhtmlBannerGrid');
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('banner/banner')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('banner_id', array(
            'header'    => Mage::helper('banner')->__('Banner Id'),
            'align'     => 'left',
            'index'     => 'banner_id',
        ));

        $this->addColumn('group_id', array(
            'header'    => Mage::helper('banner')->__('Group Id'),
            'align'     => 'left',
            'index'     => 'group_id',
        ));

        $this->addColumn('image', array(
            'header'    => Mage::helper('banner')->__('Image'),
            'align'     => 'left',
            'index'     => 'image',
            'renderer'  => 'Sonali_Banner_Block_Adminhtml_Banner_Grid_Renderer_Image'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('banner')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
            'renderer' => 'Sonali_Banner_Block_Adminhtml_Banner_Grid_Renderer_Status',
        ));

        $this->addColumn('position', array(
            'header'    => Mage::helper('banner')->__('Position'),
            'align'     => 'left',
            'index'     => 'position'
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('banner')->__('Created At'),
            'align'     => 'left',
            'index'     => 'created_at',
        ));

        return parent::_prepareColumns();
    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('banner_id' => $row->getId()));
    }
   
}