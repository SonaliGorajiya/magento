<?php
class Sonali_Banner_Block_Adminhtml_Group_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('groupAdminhtmlGroupGrid');
        $this->setDefaultSort('group_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('banner/group')->getCollection();
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
            'index'     => 'name'
        ));

        $this->addColumn('group_key', array(
            'header'    => Mage::helper('banner')->__('Group Key'),
            'align'     => 'left',
            'index'     => 'group_key'
        ));

        $this->addColumn('height', array(
            'header'    => Mage::helper('banner')->__('Height'),
            'align'     => 'left',
            'index'     => 'height'
        ));

        $this->addColumn('width', array(
            'header'    => Mage::helper('banner')->__('Width'),
            'align'     => 'left',
            'index'     => 'width'
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('banner')->__('Created At'),
            'align'     => 'left',
            'index'     => 'created_at'
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('group_id');
        $this->getMassactionBlock()->setFormFieldName('group_id');
         
        $this->getMassactionBlock()->addItem('delete', array(
        'label'=> Mage::helper('banner')->__('Delete'),
        'url'  => $this->getUrl('*/*/massDelete', array('' => '')),
        'confirm' => Mage::helper('banner')->__('Are you sure?')
        ));
         
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('group_id' => $row->getId()));
    }
}