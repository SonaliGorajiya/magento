<?php
 
class Ccc_Salesman_Block_Adminhtml_Salesman_Edit_Tab_Price extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
         
        $this->setDefaultSort('entity_id');
        $this->setId('adminhtmlsalesmanPriceGrid');
        $this->setUseAjax(true);
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);

    }

    protected function _getCollectionClass()
    {
        return 'salesman/salesman_price_collection';
    }
     
    protected function _prepareCollection()
    {
        // $query = "SELECT SP.*,P.* FROM `product` P LEFT JOIN `salesman_price` SP ON P.`product_id`=SP.`product_id` AND SP.`salesman_id` = {$id}";
        // $salesmanPrices = Ccc::getModel('Salesman_Price')->fetchAll($query);

        $collection = Mage::getResourceModel($this->_getCollectionClass());//->getSelect()->joinLeft(array('sp' => 'salesman_price'),'`product`.`product_id` = `sp`.`product_id`');
        $this->setCollection($collection);
         
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id',
            array(
                'header'=> $this->__('Entity Id'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'entity_id'
            )
        );

        $this->addColumn('salesman_id',
            array(
                'header'=> $this->__('Salesman Id'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'salesman_id'
            )
        );

        $this->addColumn('product_id',
            array(
                'header'=> $this->__('Product Id'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'product_id'
            )
        );

       /* $this->addColumn('name',
            array(
                'header'=> $this->__('Name'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'name'
            )
        );

        $this->addColumn('sku',
            array(
                'header'=> $this->__('Sku'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'sku'
            )
        );

        $this->addColumn('price',
            array(
                'header'=> $this->__('Price'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'price'
            )
        );
*/
        $this->addColumn('salesman_price',
            array(
                'header'=> $this->__('Salesman Price'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'salesman_price'
            )
        );
         
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('salesman')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('salesman')->__('Remove'),
                        'url'       => array('base'=> '*/*/delete'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

        // $this->addExportType('*/*/exportCsv', Mage::helper('salesman')->__('CSV'));
        // $this->addExportType('*/*/exportXml', Mage::helper('salesman')->__('Excel XML'));
        return parent::_prepareColumns();
    }

    // protected function _prepareMassaction()
    // {
    //     $this->setMassactionIdField('salesman_id');
    //     $this->getMassactionBlock()->setFormFieldName('salesman_id');

    //     $this->getMassactionBlock()->addItem('delete', array(
    //          'label'    => Mage::helper('salesman')->__('Delete'),
    //          'url'      => $this->getUrl('*/*/massDelete'),
    //          'confirm'  => Mage::helper('salesman')->__('Are you sure?')
    //     ));

    //     return $this;
    // }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=> true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }
}