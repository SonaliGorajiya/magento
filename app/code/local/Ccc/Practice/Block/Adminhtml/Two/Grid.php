
<?php

class Ccc_Practice_Block_Adminhtml_Two_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('practiceAdminhtmlPracticeGrid');
        $this->setDefaultSort('attribute_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {

        $attributeCollection = Mage::getResourceModel('eav/entity_attribute_collection');
        $attributeCollection->addFieldToFilter('frontend_input', 'select');

        $resultArray = array();

        foreach ($attributeCollection as $attribute) {
            $attributeId = $attribute->getAttributeId();
            $attributeCode = $attribute->getAttributeCode();

            if ($attribute->usesSource()) {
                $options = Mage::getModel('eav/entity_attribute_option')
                    ->getCollection()
                    ->setAttributeFilter($attributeId)
                    ->setPositionOrder('asc', true)
                    ->load();

                foreach ($options as $option) {
                    $optionId = $option->getOptionId();
                    $optionName = $option->getValue();

                    $resultArray[] = array(
                        'attribute_id' => $attributeId,
                        'attribute_code' => $attributeCode,
                        'option_id' => $optionId,
                        'option_name' => $optionName
                    );
                }
            }
        }

        $collection = new Varien_Data_Collection();

        foreach ($resultArray as $data) {
            $row = new Varien_Object();
            $row->setData($data);
            $collection->addItem($row);
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('attribute_id', array(
            'header'    => Mage::helper('product')->__('Attribute Id'),
            'align'     => 'left',
            'index'     => 'attribute_id'
        ));

        $this->addColumn('attribute_code', array(
            'header'    => Mage::helper('product')->__('Attribute Code'),
            'align'     => 'left',
            'index'     => 'attribute_code'
        ));

        $this->addColumn('option_id', array(
            'header'    => Mage::helper('product')->__('Option Id'),
            'align'     => 'left',
            'index'     => 'option_id'
        ));

        $this->addColumn('option_name', array(
            'header'    => Mage::helper('product')->__('Option Name'),
            'align'     => 'left',
            'index'     => 'option_name'
        ));

        return parent::_prepareColumns();
    }
}