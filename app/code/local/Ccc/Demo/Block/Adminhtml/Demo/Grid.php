<?php
 
class Ccc_Demo_Block_Adminhtml_Demo_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
         
        $this->setDefaultSort('attribute_id');
        $this->setId('adminhtmlDemoGrid');
        // $this->setUseAjax(true);
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);

    }

    protected function _getCollectionClass()
    {
        return 'demo/demo_collection';
    }
     
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        // $collection = Mage::getModel('demo/demo')->getCollection();
        // echo "<pre>";
        // print_r(Mage::getModel('demo/demo'));
        // die;
        $this->setCollection($collection);
         
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('attribute_id',
            array(
                'header'=> $this->__('Attribute Id'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'attribute_id'
            )
        );
         
        $this->addColumn('entity_type_id',
            array(
                'header'=> $this->__('Entity_type Id'),
                'index' => 'entity_type_id'
            )
        );
          
        $this->addColumn('attribute_code',
            array(
                'header'=> $this->__('Attribute Code'),
                'index' => 'attribute_code'
            )
        );   

        $this->addColumn('attribute_model',
            array(
                'header'=> $this->__('Attribute Model'),
                'index' => 'attribute_model'
            )
        );    

        $this->addColumn('backend_model',
            array(
                'header'=> $this->__('Backend Model'),
                'index' => 'backend_model'
            )
        );

        $this->addColumn('backend_type',
            array(
                'header'=> $this->__('Backend Type'),
                'index' => 'backend_type'
            )
        );

        $this->addColumn('source_model',
            array(
                'header'=> $this->__('Source Model'),
                'index' => 'source_model'
            )
        );        


      /*  $this->addColumn('created_at',
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
        );*/

        // $this->addColumn('action',
        //     array(
        //         'header'    =>  Mage::helper('demo')->__('Action'),
        //         'width'     => '100',
        //         'type'      => 'action',
        //         'getter'    => 'getId',
        //         'actions'   => array(
        //             array(
        //                 'caption'   => Mage::helper('demo')->__('Edit'),
        //                 'url'       => array('base'=> '*/*/edit'),
        //                 'field'     => 'id'
        //             )
        //         ),
        //         'filter'    => false,
        //         'sortable'  => false,
        //         'index'     => 'stores',
        //         'is_system' => true,
        // ));

        // $this->addExportType('*/*/exportCsv', Mage::helper('demo')->__('CSV'));
        // $this->addExportType('*/*/exportXml', Mage::helper('demo')->__('Excel XML'));
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('attribute_id');
        $this->getMassactionBlock()->setFormFieldName('attribute_id');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('demo')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('demo')->__('Are you sure?')
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