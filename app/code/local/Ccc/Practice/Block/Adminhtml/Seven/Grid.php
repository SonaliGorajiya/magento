<?php

class Ccc_Practice_Block_Adminhtml_Seven_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('PracticeAdminhtmlPracticeGrid');
        $this->setDefaultSort('order_count');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $orderStatuses = array(
                                'pending',
                                'processing',
                                'complete',
                                'closed',
                                'canceled',
                                'holded',
                                'payment_review',
                            );

        $collection = Mage::getModel('sales/order')->getCollection()
            ->addFieldToSelect(array('entity_id', 'customer_id'))
            ->addFieldToFilter('main_table.status', array('in' => $orderStatuses));

        $collection->getSelect()->join(
            array('status' => Mage::getSingleton('core/resource')->getTableName('sales/order_status')),
            'status.status = main_table.status',
            array('order_status' => 'status.label')
        );

        $collection->getSelect()->join(
            array('customer' => Mage::getSingleton('core/resource')->getTableName('customer/entity')),
            'customer.entity_id = main_table.customer_id',
            array('email' => 'customer.email')
        );

        $result = array();

        foreach ($collection as $order) {
            $result[] = array(
                'order_id' => $order->getEntityId(),
                'customer_id' => $order->getCustomerId(),
                'order_status' => $order->getOrderStatus(),
                'email' => $order->getEmail(),        
            );
        }

        $collection = new Varien_Data_Collection();

        foreach ($result as $data) {
            $item = new Varien_Object($data);
            $collection->addItem($item);
        }

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('customer_id', array(
            'header'    => Mage::helper('category')->__('Customer Id'),
            'align'     => 'left',
            'index'     => 'customer_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('category')->__('Customer Name'),
            'align'     => 'left',
            'index'     => 'name',
            'renderer'  =>'Ccc_Practice_Block_Adminhtml_Seven_Renderer_Name'
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('category')->__('Customer Email'),
            'align'     => 'left',
            'index'     => 'email',
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('category')->__('Status'),
            'align'     => 'left',
            'index'     => 'order_status',
        ));

        $this->addColumn('order_count', array(
            'header'    => Mage::helper('category')->__('Order Count'),
            'align'     => 'left',
            'renderer'  => 'Ccc_Practice_Block_Adminhtml_Seven_Renderer_Ordercount',

        ));

        return parent::_prepareColumns();
    }
    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('category_id' => $row->getId()));
    }
}