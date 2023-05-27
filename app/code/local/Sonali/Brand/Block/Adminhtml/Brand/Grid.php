<?php
 
class Sonali_Brand_Block_Adminhtml_Brand_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
         
        $this->setDefaultSort('brand_id');
        $this->setId('adminhtmlBrandGrid');
        // $this->setUseAjax(true);
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);

    }

    protected function _getCollectionClass()
    {
        return 'brand/brand_collection';
    }
     
    protected function _prepareCollection()
    {
        // echo "<pre>";
        // print_r(Mage::getModel("brand/brand"));
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
         
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('brand_id',
            array(
                'header'=> $this->__('Brand Id'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'brand_id'
            )
        );
         
        $this->addColumn('name',
            array(
                'header'=> $this->__('Name'),
                'index' => 'name'
            )
        );    

        $this->addColumn('image',
            array(
                'header'=> $this->__('Image'),
                'index' => 'image',
                'renderer'=>'Sonali_Brand_Block_Adminhtml_Brand_Grid_Renderer_Grid'
            )
        );       

        $this->addColumn('description',
            array(
                'header'=> $this->__('Description'),
                'index' => 'description'
            )
        );

        $this->addColumn('created_at',
            array(
                'header'=> $this->__('Created Date'),
                'index' => 'created_at'
            )
        );

        $this->addColumn('updated_at',
            array(
                'header'=> $this->__('Updated Date'),
                'index' => 'updated_at'
            )
        );

        // $this->addColumn('action',
        //     array(
        //         'header'    =>  Mage::helper('brand')->__('Action'),
        //         'width'     => '100',
        //         'type'      => 'action',
        //         'getter'    => 'getId',
        //         'actions'   => array(
        //             array(
        //                 'caption'   => Mage::helper('brand')->__('Edit'),
        //                 'url'       => array('base'=> '*/*/edit'),
        //                 'field'     => 'id'
        //             )
        //         ),
        //         'filter'    => false,
        //         'sortable'  => false,
        //         'index'     => 'stores',
        //         'is_system' => true,
        // ));

        // $this->addExportType('*/*/exportCsv', Mage::helper('brand')->__('CSV'));
        // $this->addExportType('*/*/exportXml', Mage::helper('brand')->__('Excel XML'));
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('brand_id');
        $this->getMassactionBlock()->setFormFieldName('brand_id');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('brand')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('brand')->__('Are you sure?')
        ));

        return $this;
    }

    // public function getGridUrl()
    // {
    //     return $this->getUrl('*/*/grid', array('_current'=> true));
    // }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }
}