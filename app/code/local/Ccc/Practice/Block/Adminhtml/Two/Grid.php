<?php
class Ccc_Practice_Block_Adminhtml_Two_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
       $attributeCollection = Mage::getResourceModel('eav/entity_attribute_collection');
            // ->addFieldToFilter('entity_type_id', Mage_Catalog_Model_Product::ENTITY);

        $attributeOptionCollection = Mage::getResourceModel('eav/entity_attribute_option_collection');

        $attributeOptionCollection->getSelect()
            ->join(
                array('attribute' => $attributeCollection->getTable('eav/attribute')),
                'attribute.attribute_id = main_table.attribute_id',
                array('attribute_code' => 'attribute.attribute_code')
            );

        $attributeOptionCollection->getSelect()->columns(array(
            'attribute_id' => 'main_table.attribute_id',
            'attribute_code' => 'attribute.attribute_code',
            'option_id' => 'main_table.option_id',
        ));



        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($attributeOptionCollection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('attribute_id', array(
            'header'    => Mage::helper('category')->__('Attribute Id'),
            'align'     => 'left',
            'index'     => 'attribute_id',
        ));

        $this->addColumn('attribute_code', array(
            'header'    => Mage::helper('category')->__('Attribute Code'),
            'align'     => 'left',
            'index'     => 'attribute_code',
        ));

        $this->addColumn('option_id', array(
            'header'    => Mage::helper('category')->__('Option Id'),
            'align'     => 'left',
            'index'     => 'option_id',
        ));

        $this->addColumn('oprion_name', array(
            'header'    => Mage::helper('category')->__('Option Name'),
            'align'     => 'left',
            'index'     => 'oprion_name',
            'renderer'  =>'ccc_practice_block_adminhtml_two_renderer_value'
        ));

        

        return parent::_prepareColumns();
    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('category_id' => $row->getId()));
    }
   
}