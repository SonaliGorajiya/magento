<?php
 
class Ccc_Category_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
         
        $this->setDefaultSort('category_id');
        $this->setId('adminhtmlCategoryGrid');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);

    }

    protected function _getCollectionClass()
    {
        return 'category/category_collection';
    }
     
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
         
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('category_id',
            array(
                'header'=> $this->__('Category Id'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'category_id'
            )
        );
         
        $this->addColumn('parent_id',
            array(
                'header'=> $this->__('Parent Id'),
                'index' => 'parent_id'
            )
        );
          
        $this->addColumn('path',
            array(
                'header'=> $this->__('Path'),
                'index' => 'path'
            )
        );   

        $this->addColumn('name',
            array(
                'header'=> $this->__('Name'),
                'index' => 'name'
            )
        );    

        $this->addColumn('status',
            array(
                'header'=> $this->__('Status'),
                'index' => 'status'
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
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('category_id');
        $this->getMassactionBlock()->setFormFieldName('category_id');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('category')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('category')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }
}