<?php


class Sonali_Brand_Model_Observer
{
     public function prepareRewrite($brandModel)
    {
        $brandId = $brandModel->getId();
        $requestPath = strtolower(str_replace(" ", "-", $brandModel->getData('name'))).'.html';
        $targetPath = 'brand/view/view/brand_id/'.$brandId;
        return $requestPath;
    }

    public function generateBrandRewriteUrl($observer)
    {
        $brand = $observer->getBrand();
        $urlKey = $brand->getUrlKey();
        $urlKey = $this->prepareRewrite($brand);
        echo $brand->getId();
        $rewrite = Mage::getModel('core/url_rewrite');
        $rewrite->setStoreId($brand->getStoreId())
                ->setIdPath('brand/' . $brand->getId())
                ->setRequestPath($urlKey)
                ->setTargetPath('brand/view/index/brand_id/'. $brand->getId())
                ->setIsSystem(0)
                ->setOptions('')
                ->setDescription('')
                ->save();
    }
}