<?php
class Ccc_Salesman_Block_Adminhtml_Salesman_Edit_Tab_Price extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('salesmanAdminhtmlSalesmanPriceGrid');
        $this->setDefaultSort('salesman_id');
        $this->setDefaultDir('DESC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('salesman/salesman_price')->getCollection();
        $collection->getSelect()
                    ->joinRight(
                        array('p'=> 'product'),
                        "p.product_id = main_table.product_id"
                    );

        $this->setCollection($collection);
        Mage::register('salesman_price', $collection->getData());

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('salesman')->__('Entity Id'),
            'align'     => 'left',
            'index'     => 'entity_id',
        ));

        $this->addColumn('product_id', array(
            'header'    => Mage::helper('salesman')->__('Product Id'),
            'align'     => 'left',
            'index'     => 'product_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('salesman')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('salesman')->__('SKU'),
            'align'     => 'left',
            'index'     => 'sku',
        ));

        $this->addColumn('cost', array(
            'header'    => Mage::helper('salesman')->__('Cost'),
            'align'     => 'left',
            'index'     => 'cost',
        ));

        $this->addColumn('price', array(
            'header'    => Mage::helper('salesman')->__('Price'),
            'align'     => 'left',
            'index'     => 'price',
        ));

        $this->addColumn('salesman_price', array(
            'header'    => Mage::helper('salesman')->__('Salesman Price'),
            'align'     => 'left',
            'index'     => 'salesman_price[]',
            'type'      => 'input'
        ));


        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('salesman_price');
        $this->getMassactionBlock()->setFormFieldName('product_id');
        
        $this->getMassactionBlock()->addItem('update', array(
        'label'=> Mage::helper('salesman')->__('Update'),
        'url'  => $this->getUrl('*/*/massUpdate', array('salesman_id' => $this->getRequest()->getParam('salesman_id'))),
        'confirm' => Mage::helper('salesman')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('delete', array(
        'label'=> Mage::helper('salesman')->__('Delete'),
        'url'  => $this->getUrl('*/*/massDelete', array('' => '')),
        'confirm' => Mage::helper('salesman')->__('Are you sure?')
        ));
         
        return $this;
    }


    // protected function _afterLoadCollection()
    // {
    //     $this->getCollection()->walk('afterLoad');
    //     parent::_afterLoadCollection();
    // }

    // protected function _filterStoreCondition($collection, $column)
    // {
    //     if (!$value = $column->getFilter()->getValue()) {
    //         return;
    //     }

    //     $this->getCollection()->addStoreFilter($value);
    // }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('salesman_id' => $row->getId()));
    }
}





    