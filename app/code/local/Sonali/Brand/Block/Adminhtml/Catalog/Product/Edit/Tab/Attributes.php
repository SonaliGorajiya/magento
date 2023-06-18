<?php
// echo "string";die;
class Sonali_Brand_Block_Adminhtml_Catalog_Product_Edit_Tab_Attributes extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Attributes
{

    // protected function _prepareForm()
    // {
    //     $group = $this->getGroup();
    //     if ($group) {
    //         $form = new Varien_Data_Form();

    //         // Initialize product object as form property to use it during elements generation
    //         $form->setDataObject(Mage::registry('product'));

    //         $fieldset = $form->addFieldset('group_fields' . $group->getId(), array(
    //             'legend' => Mage::helper('catalog')->__($group->getAttributeGroupName()),
    //             'class' => 'fieldset-wide'
    //         ));

    //         $brands = Mage::getModel('brand/brand')->getCollection()->getItems();
    //         // echo "<pre>";
    //         // print_r($brands);die;
    //         foreach($brands as $brand){
    //             $options[$brand->brand_id] = $brand->name ; 
    //         }
    //         // print_r($options); die;

    //         $fieldset->addField('brand', 'select', array(
    //             'label' => Mage::helper('brand')->__('Brand'),
    //             'required' => true,
    //             'name' => 'brand',
    //             'values' => $options,
    //         ));

    //         $attributes = $this->getGroupAttributes();

    //         $this->_setFieldset($attributes, $fieldset, array('gallery'));

    //         $urlKey = $form->getElement('url_key');
    //         if ($urlKey) {
    //             $urlKey->setRenderer(
    //                 $this->getLayout()->createBlock('adminhtml/catalog_form_renderer_attribute_urlkey')
    //             );
    //         }

    //         $tierPrice = $form->getElement('tier_price');
    //         if ($tierPrice) {
    //             $tierPrice->setRenderer(
    //                 $this->getLayout()->createBlock('adminhtml/catalog_product_edit_tab_price_tier')
    //             );
    //         }

    //         $groupPrice = $form->getElement('group_price');
    //         if ($groupPrice) {
    //             $groupPrice->setRenderer(
    //                 $this->getLayout()->createBlock('adminhtml/catalog_product_edit_tab_price_group')
    //             );
    //         }

    //         $recurringProfile = $form->getElement('recurring_profile');
    //         if ($recurringProfile) {
    //             $recurringProfile->setRenderer(
    //                 $this->getLayout()->createBlock('adminhtml/catalog_product_edit_tab_price_recurring')
    //             );
    //         }

    //         // Add new attribute button if it is not an image tab
    //         if (!$form->getElement('media_gallery')
    //             && Mage::getSingleton('admin/session')->isAllowed('catalog/attributes/attributes')
    //         ) {
    //             $headerBar = $this->getLayout()->createBlock('adminhtml/catalog_product_edit_tab_attributes_create');

    //             $headerBar->getConfig()
    //                 ->setTabId('group_' . $group->getId())
    //                 ->setGroupId($group->getId())
    //                 ->setStoreId($form->getDataObject()->getStoreId())
    //                 ->setAttributeSetId($form->getDataObject()->getAttributeSetId())
    //                 ->setTypeId($form->getDataObject()->getTypeId())
    //                 ->setProductId($form->getDataObject()->getId());

    //             $fieldset->setHeaderBar($headerBar->toHtml());
    //         }

    //         if ($form->getElement('meta_description')) {
    //             $form->getElement('meta_description')->setOnkeyup('checkMaxLength(this, 255);');
    //         }

    //         $values = Mage::registry('product')->getData();

    //         // Set default attribute values for new product
    //         if (!Mage::registry('product')->getId()) {
    //             foreach ($attributes as $attribute) {
    //                 if (!isset($values[$attribute->getAttributeCode()])) {
    //                     $values[$attribute->getAttributeCode()] = $attribute->getDefaultValue();
    //                 }
    //             }
    //         }

    //         if (Mage::registry('product')->hasLockedAttributes()) {
    //             foreach (Mage::registry('product')->getLockedAttributes() as $attribute) {
    //                 $element = $form->getElement($attribute);
    //                 if ($element) {
    //                     $element->setReadonly(true, true);
    //                 }
    //             }
    //         }
    //         $form->addValues($values);
    //         $form->setFieldNameSuffix('product');

    //         Mage::dispatchEvent('adminhtml_catalog_product_edit_prepare_form', array('form' => $form));

    //         $this->setForm($form);
    //     }
    // }
}