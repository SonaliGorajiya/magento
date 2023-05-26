<?php
class Sonali_Eavmgmt_Block_Adminhtml_Eavmgmt_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('eavmgmtAdminhtmlEavmgmtGrid');
        $this->setDefaultSort('attribute_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('attribute_id');
        $this->getMassactionBlock()->setFormFieldName('attribute_id');
         
        $this->getMassactionBlock()->addItem('delete', array(
        'label'=> Mage::helper('eavmgmt')->__('Delete'),
        'url'  => $this->getUrl('*/*/massDelete', array('' => '')),
        'confirm' => Mage::helper('eavmgmt')->__('Are you sure?')
        ));
         
        return $this;
    }
    
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('eavmgmt/eavmgmt')->getCollection();
        
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('attribute_id',
            array(
                'header'=> $this->__('Eavmgmt Id'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'attribute_id'
            )
        );

        $this->addColumn('entity_type_code',
            array(
                'header'=> $this->__('Entity Type'),
                'index' => 'entity_type_code',
            )
        );  
         
        $this->addColumn('attribute_code',
            array(
                'header'=> $this->__('Attribute Code'),
                'index' => 'attribute_code'
            )
        );    

        $this->addColumn('frontend_label',
            array(
                'header'=> $this->__('Attribute Name'),
                'index' => 'frontend_label'
            )
        );       

        $this->addColumn('frontend_input',
            array(
                'header'=> $this->__('Input Type'),
                'index' => 'frontend_input'
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

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('eavmgmt')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('eavmgmt')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('eavmgmt')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('eavmgmt')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('attribute_id' => $row->getId()));
    }
   
}   