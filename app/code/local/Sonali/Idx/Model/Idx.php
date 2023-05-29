<?php

class Sonali_Idx_Model_Idx extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        $this->_init('idx/idx');
    }

    public function checkBrand()
    {
        $idxBrandId = $this->getData('brand_id');
        if (!$idxBrandId) {
            return false;
        }
        return true;
    }

    public function checkCollection()
    {
        $idxCollectionId = $this->getData('collection_id');
        if (!$idxCollectionId) {
            return false;
        }
        return true;
    }

    public function updateMainBrand($idxBrandNames)
    {
        $brandCollection = Mage::getModel('brand/brand')->getCollection();
        $brandNames = $brandCollection->getConnection()
            ->fetchPairs($brandCollection->getSelect()->columns(['brand_id','name']));

        $newBrands = array_diff($idxBrandNames, $brandNames);
        foreach ($newBrands as $brandName) {
            $brand = Mage::getModel('brand/brand');
            $brand->name = $brandName;
            $brand->save();
        }

        $newBrandNames = $brandCollection->getConnection()
            ->fetchPairs($brandCollection->getSelect()->columns(['brand_id','name']));
        return $newBrandNames;    
    }

    public function updateMainCollection($idxCollectionNames)
    {
        $collection = Mage::getModel('collection/collection')->getCollection();
        $collectionName = $collection->getConnection()
            ->fetchPairs($collection->getSelect()->columns(['collection_id','name']));

        $newCollectios = array_diff($idxCollectionNames, $collectionName);
        foreach ($newCollectios as $collectionName) {
            $collectionmodel = Mage::getModel('collection/collection');
            $collectionmodel->name = $collectionName;
            $collectionmodel->save();
        }

        $newCollectionNames = $collection->getConnection()
            ->fetchPairs($collection->getSelect()->columns(['collection_id','name']));
        return $newCollectionNames;    
    }

    public function updateMainProduct($idxSkus)
    {

        $productCollection = Mage::getModel('product/product')->getCollection();
        foreach ($productCollection as $product) {
            $productSkus[$product->getData('product_id')] = $product->getData('sku');
        }

        $newProducts = array_diff($idxSkus, $productSkus);
        foreach ($newProducts as $productSku) {
            $productModel = Mage::getModel('product/product');
            $productModel->sku = $productSku;
            $productModel->save();
        }

        $productCollection = Mage::getModel('product/product')->getCollection();
        foreach ($productCollection as $product) {
            $productSkus[$product->getData('product_id')] = $product->getData('sku');
        }
        return $productSkus;    
    }

}
