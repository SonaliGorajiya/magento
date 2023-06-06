<?php
class Sonali_Banner_Block_Adminhtml_Group_Edit_Form_Gallery_Content extends Mage_Adminhtml_Block_Widget
{
    protected $_uploaderType = 'uploader/multiple';

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('banner/image.phtml');
    }

    public function getBannerCollection()
    {
        $collection = Mage::getModel('banner/banner')->getCollection();
        $collection->addFieldToFilter('group_id',$this->getRequest()->getParam('group_id'));

        return $collection->getItems();
    }

}