<?php
use Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory;
class Sonali_Eavmgmt_Model_AttributeFetcher
{
    protected $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function getAllAttributes()
    {
        $attributeCollection = $this->collectionFactory->create();
        $attributes = $attributeCollection->getItems();

        foreach ($attributes as $attribute) {
            // Access attribute properties
            $attributeCode = $attribute->getAttributeCode();
            $attributeLabel = $attribute->getDefaultFrontendLabel();
            // ... Retrieve other attribute properties as needed

            // Print or process attribute information
            echo "Attribute Code: $attributeCode, Label: $attributeLabel\n";
        }
    }
}