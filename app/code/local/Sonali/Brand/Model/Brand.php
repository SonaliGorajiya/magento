<?php 

class Sonali_Brand_Model_Brand extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {  
        $this->_init('brand/brand');
    }  

    public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;

        return $this;
    }

    public function saveImage($img, $path)
    {
        $uploader = new Varien_File_Uploader($img);
        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(false);

        $uploader->save($path);

        $filePath = $path . DS . $uploader->getUploadedFileName();

        $this->$img = $uploader->getUploadedFileName();
        return $this;
    }

    public function saveRewriteUrlKey()
    {
        $brandId = $this->brand_id;
        $brand = Mage::getModel('brand/brand')->load($brandId);

        $urlKey = $this->url_key;
        $rewriteUrl = 'brand/' . $urlKey;

        $rewrite = Mage::getModel('core/url_rewrite')->getCollection()
            ->addFieldToFilter('request_path', $rewriteUrl)
            ->getFirstItem();

        if (!$rewrite->getId()) {
            $rewrite->setStoreId(0) 
                ->setIdPath('brand/' . $brandId)
                ->setRequestPath($rewriteUrl)
                ->setTargetPath('brand/index/view/id/' . $brandId)
                ->setIsSystem(0)
                ->save();
        }

    }
}