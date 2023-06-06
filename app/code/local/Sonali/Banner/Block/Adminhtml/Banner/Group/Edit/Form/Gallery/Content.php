<?php
class Sonali_Banner_Block_Adminhtml_Banner_group_Edit_Form_Gallery_Content extends Mage_Adminhtml_Block_Widget
{
    protected $_uploaderType = 'uploader/multiple';

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('banner/gallery.phtml');
    }

    protected function _prepareLayout()
    {
        $this->setChild('uploader',
            $this->getLayout()->createBlock($this->_uploaderType)
        );

        $this->getUploader()->getUploaderConfig()
            ->setFileParameterName('image')
            ->setTarget(Mage::getModel('adminhtml/url')->addSessionParam()->getUrl(
                '*/*/upload',
                array('_query' => false)
            ));

        $browseConfig = $this->getUploader()->getButtonConfig();
        $browseConfig
            ->setAttributes(array(
                'accept' => $browseConfig->getMimeTypesByExtensions('gif, png, jpeg, jpg')
            ));

        // Mage::dispatchEvent('catalog_product_gallery_prepare_layout', array('block' => $this));

        return parent::_prepareLayout();
    }

    public function getUploader()
    {
        return $this->getChild('uploader');
    }

    public function getUploaderHtml()
    {
        return $this->getChildHtml('uploader');
    }

    public function getJsObjectName()
    {
        return $this->getHtmlId() . 'JsObject';
    }

    public function getAddImagesButton()
    {
        return $this->getButtonHtml(
            Mage::helper('banner')->__('Add New Images'),
            $this->getJsObjectName() . '.showUploader()',
            'add',
            $this->getHtmlId() . '_add_images_button'
        );
    }

    public function getImagesJson()
    {
        if(is_array($this->getElement()->getValue())) {
            $value = $this->getElement()->getValue();
            if(count($value['images'])>0) {
                foreach ($value['images'] as &$image) {
                    $image['url'] = Mage::getSingleton('catalog/product_media_config')
                                        ->getMediaUrl($image['file']);
                }
                return Mage::helper('core')->jsonEncode($value['images']);
            }
        }
        return '[]';
    }

    public function getImagesValuesJson()
    {
        $values = array();
        foreach ($this->getMediaAttributes() as $attribute) {
            /* @var $attribute Mage_Eav_Model_Entity_Attribute */
            $values[$attribute->getAttributeCode()] = $this->getElement()->getDataObject()->getData(
                $attribute->getAttributeCode()
            );
        }
        return Mage::helper('core')->jsonEncode($values);
    }

    /**
     * Enter description here...
     *
     * @return array
     */
    public function getImageTypes()
    {
        $imageTypes = array();
        foreach ($this->getMediaAttributes() as $attribute) {
            /* @var $attribute Mage_Eav_Model_Entity_Attribute */
            $imageTypes[$attribute->getAttributeCode()] = array(
                'label' => $attribute->getFrontend()->getLabel() . ' '
                         . Mage::helper('banner')->__($this->getElement()->getScopeLabel($attribute)),
                'field' => $this->getElement()->getAttributeFieldName($attribute)
            );
        }
        return $imageTypes;
    }

    public function hasUseDefault()
    {
        foreach ($this->getMediaAttributes() as $attribute) {
            if($this->getElement()->canDisplayUseDefault($attribute))  {
                return true;
            }
        }

        return false;
    }

    /**
     * Enter description here...
     *
     * @return array
     */
    public function getMediaAttributes()
    {
        return $this->getElement()->getDataObject()->getMediaAttributes();
    }

    public function getImageTypesJson()
    {
        return Mage::helper('core')->jsonEncode($this->getImageTypes());
    }

}
