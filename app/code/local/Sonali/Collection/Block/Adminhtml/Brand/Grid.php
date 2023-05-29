<?php

class Sonali_Collection_Block_Adminhtml_Collection_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        // $this->setTemplate('collection/grid.phtml');
        $this->setId('collectionAdminhtmlCollectionGrid');
        $this->setDefaultSort('collection_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('collection/collection')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('name', array(
            'header'    => Mage::helper('collection')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('image', array(
            'header'    => Mage::helper('collection')->__('Image'),
            'align'     => 'left',
            'index'     => 'image',
            'renderer' => 'collection/adminhtml_collection_grid_renderer_image',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('collection_id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('collection_id');
        $this->getMassactionBlock()->setFormFieldName('collection');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('collection')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('collection')->__('Are you sure?')
        ));
        return $this;
    }
}