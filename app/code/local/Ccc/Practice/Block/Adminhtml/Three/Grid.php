<?php

class Ccc_Practice_Block_Adminhtml_Three_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $collection = Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->getSelect()
            ->join(
                array('attribute' => Mage::getSingleton('core/resource')->getTableName('eav/attribute')),
                'attribute.attribute_id = main_table.attribute_id',
                array('attribute_code' => 'attribute.attribute_code')
            )
            ->columns(array('option_count' => new Zend_Db_Expr('COUNT(main_table.option_id)')))
            ->group('main_table.attribute_id')
            ->having('option_count > ?', 10);

        $resultCollection = Mage::getModel('eav/entity_attribute')->getCollection();
        $resultCollection->getSelect()->reset()->from(array('main_table' => $collection));

        $this->setCollection($resultCollection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('attribute_id', array(
            'header'    => Mage::helper('product')->__('Attribute Id'),
            'align'     => 'left',
            'index'     => 'attribute_id'
        ));

        $this->addColumn('attribute_code', array(
            'header'    => Mage::helper('product')->__('Attribute Code'),
            'align'     => 'left',
            'index'     => 'attribute_code'
        ));

        $this->addColumn('option_count', array(
            'header'    => Mage::helper('product')->__('Option Count'),
            'align'     => 'left',
            'index'     => 'option_count'
        ));

        return parent::_prepareColumns();
    }
}