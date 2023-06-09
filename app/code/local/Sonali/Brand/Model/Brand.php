<?php
class Sonali_Brand_Model_Brand extends Mage_Core_Model_Abstract
{
	function __construct()
	{
		$this->_init('brand/brand');
	}

	public function saveImage($img, $path)
	{
		$uploader = new Varien_File_Uploader($img);
        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'webp']);
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(false);
        $uploader->save($path);
        $filePath = $path . DS . $uploader->getUploadedFileName();
        $this->$img = $uploader->getUploadedFileName();
        return $this;
	}
}