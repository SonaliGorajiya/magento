<?php

class Sonali_Eavmgmt_Block_Adminhtml_eavmgmt_Grid extends Mage_Eav_Block_Adminhtml_Attribute_Grid_Abstract
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('eavmgmtAdminhtmleavmgmtGrid');
        $this->setDefaultSort('attribute_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('eavmgmt/eavmgmt_collection');

        $this->setCollection($collection);
        return parent::_prepareCollection();

    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
        
        $this->addColumn('attribute_id', array(
            'header'=>Mage::helper('eav')->__('Index'),
            'sortable'=>true,
            'index'=>'attribute_id'
        ));

        $this->addColumn('entity_type_code', array(
            'header'=>Mage::helper('eav')->__('Entity Type Code'),
            'sortable'=>true,
            'index'=>'entity_type_code'
        ));

        $this->addColumn('attribute_code', array(
            'header'=>Mage::helper('eav')->__('Attribute Code'),
            'sortable'=>true,
            'index'=>'attribute_code'
        ));

        $this->addColumn('frontend_input', array(
            'header'=>Mage::helper('eav')->__('Frontend Input'),
            'sortable'=>true,
            'index'=>'frontend_input'
        ));

        $this->addColumn('frontend_label', array(
            'header'=>Mage::helper('eav')->__('Attribute Name'),
            'sortable'=>true,
            'index'=>'frontend_label'
        ));

        $this->addColumn('backend_input', array(
            'header'=>Mage::helper('eav')->__('Backend Input'),
            'sortable'=>true,
            'index'=>'backend_input'
        ));

        $this->addColumn('attribute_id', array(
            'header'=>Mage::helper('eav')->__('Index'),
            'sortable'=>true,
            'index'=>'attribute_id'
        ));

        $this->addColumn('entity_type_code', array(
            'header'=>Mage::helper('eav')->__('Entity Type Code'),
            'sortable'=>true,
            'index'=>'entity_type_code'
        ));


        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('eavmgmt')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('eavmgmt')->__('show options'),
                        'url'       => array('base'=> '*/*/showoption'),
                        'field'     => 'eavmgmt_id',
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

        return $this;

    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('eavmgmt_id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('attribute_id');
        $this->getMassactionBlock()->setFormFieldName('attribute_id');

        $this->getMassactionBlock()->addItem('import_attribute', array(
             'label'    => Mage::helper('eavmgmt')->__('Export'),
             'url'      => $this->getUrl('*/*/selectedExport'),
             'confirm'  => Mage::helper('eavmgmt')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('import_attribute_options', array(
             'label'    => Mage::helper('eavmgmt')->__('Export Options'),
             'url'      => $this->getUrl('*/*/selectedExportOptions'),
             'confirm'  => Mage::helper('eavmgmt')->__('Are you sure?')
        ));
        return $this;
    }  
   
}