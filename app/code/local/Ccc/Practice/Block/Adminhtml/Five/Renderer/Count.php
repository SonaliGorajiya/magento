<?php

class Ccc_Practice_Block_Adminhtml_Five_Renderer_Count extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract		
{
	function render($row)
	{
		$mediaGalleryAttribute = $row->getResource()->getAttribute('media_gallery');
	    if ($mediaGalleryAttribute) {
	        $mediaGallery = $mediaGalleryAttribute->getBackend();
	        $mediaGallery->afterLoad($row);

	        $galleryImages = $row->getMediaGalleryImages();

	        if ($galleryImages) {
	            $galleryImagesCount = count($galleryImages);
	        }
	    }
		return $galleryImagesCount;
	}
}