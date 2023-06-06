<?php

class Sonali_Banner_Block_Adminhtml_Banner_Group_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('bannerGroupAdminGrid');
        $this->setDefaultSort('group_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('banner/group')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('group_id', array(
            'header'    => Mage::helper('banner')->__('Group Id'),
            'align'     => 'left',
            'index'     => 'group_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('banner')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('group_key', array(
            'header'    => Mage::helper('banner')->__('Group Key'),
            'align'     => 'left',
            'index'     => 'group_key',
            // 'renderer'  => 'Sonali_Brand_Block_Adminhtml_Brand_Grid_Renderer_Image'
        ));

        $this->addColumn('height', array(
            'header'    => Mage::helper('banner')->__('Height'),
            'align'     => 'left',
            'index'     => 'height',
        ));

        $this->addColumn('width', array(
            'header'    => Mage::helper('banner')->__('Width'),
            'align'     => 'left',
            'index'     => 'width',
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('banner')->__('Create At'),
            'align'     => 'left',
            'index'     => 'created_at',
        ));
        
        // $this->addColumn('action',
        //     array(
        //         'header'    =>  Mage::helper('banner')->__('Action'),
        //         'width'     => '100',
        //         'type'      => 'action',
        //         'getter'    => 'getId',
        //         'actions'   => array(
        //             array(
        //                 'caption'   => Mage::helper('banner')->__('EDIT'),
        //                 'url'       => array('base'=> '*/*/edit'),
        //                 'field'     => 'banner_id'
        //             )
        //         ),
        //         'filter'    => false,
        //         'sortable'  => false,
        //         'index'     => 'stores',
        //         'is_system' => true,
        // ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('group_id' => $row->getId()));
    }
   
}