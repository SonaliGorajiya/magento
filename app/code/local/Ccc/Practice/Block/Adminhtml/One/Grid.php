<?php
class Ccc_Practice_Block_Adminhtml_One_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $collection = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect(array('name','cost','color','price'));
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('name', array(
            'header'    => Mage::helper('category')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('category')->__('Sku'),
            'align'     => 'left',
            'index'     => 'sku',
        ));

        $this->addColumn('cost', array(
            'header'    => Mage::helper('category')->__('Cost'),
            'align'     => 'left',
            'index'     => 'cost',
        ));

        $this->addColumn('price', array(
            'header'    => Mage::helper('category')->__('Price'),
            'align'     => 'left',
            'index'     => 'price',
        ));

        $this->addColumn('color', array(
            'header'    => Mage::helper('category')->__('Color'),
            'align'     => 'left',
            'index'     => 'color',
            'renderer'  => 'ccc_practice_block_adminhtml_one_renderer_color'
        ));

        return parent::_prepareColumns();
    }
   
}