<?php
 
class Ccc_Salesman_Block_Adminhtml_Salesman_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
         
        $this->setDefaultSort('salesman_id');
        $this->setId('adminhtmlsalesmanGrid');
        // $this->setUseAjax(true);
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);

    }

    protected function _getCollectionClass()
    {
        return 'salesman/salesman_collection';
    }
     
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
         
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('salesman_id',
            array(
                'header'=> $this->__('Salesman Id'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'salesman_id'
            )
        );
         
        $this->addColumn('first_name',
            array(
                'header'=> $this->__('First Name'),
                'index' => 'first_name'
            )
        );    

        $this->addColumn('last_name',
            array(
                'header'=> $this->__('Last Name'),
                'index' => 'last_name'
            )
        );       

        $this->addColumn('email',
            array(
                'header'=> $this->__('Email'),
                'index' => 'email'
            )
        );         

        $this->addColumn('gender',
            array(
                'header'=> $this->__('Gender'),
                'index' => 'gender'
            )
        );

        $this->addColumn('mobile',
            array(
                'header'=> $this->__('Mobile'),
                'index' => 'mobile'
            )
        );

        $this->addColumn('status',
            array(
                'header'=> $this->__('Status'),
                'index' => 'status'
            )
        );

        $this->addColumn('company',
            array(
                'header'=> $this->__('Company'),
                'index' => 'company'
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
        //         'header'    =>  Mage::helper('salesman')->__('Action'),
        //         'width'     => '100',
        //         'type'      => 'action',
        //         'getter'    => 'getId',
        //         'actions'   => array(
        //             array(
        //                 'caption'   => Mage::helper('salesman')->__('Edit'),
        //                 'url'       => array('base'=> '*/*/edit'),
        //                 'field'     => 'id'
        //             )
        //         ),
        //         'filter'    => false,
        //         'sortable'  => false,
        //         'index'     => 'stores',
        //         'is_system' => true,
        // ));

        // $this->addExportType('*/*/exportCsv', Mage::helper('salesman')->__('CSV'));
        // $this->addExportType('*/*/exportXml', Mage::helper('salesman')->__('Excel XML'));
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('salesman_id');
        $this->getMassactionBlock()->setFormFieldName('salesman_id');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('salesman')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('salesman')->__('Are you sure?')
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