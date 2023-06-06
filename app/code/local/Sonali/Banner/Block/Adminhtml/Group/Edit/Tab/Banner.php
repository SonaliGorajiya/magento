<?php
class Sonali_Banner_Block_Adminhtml_Group_Edit_Tab_Banner extends Mage_Adminhtml_Block_Catalog_Form
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }

    protected function _prepareForm()
    {
        $group = $this->getGroup();
        if ($group) {
            $form = new Varien_Data_Form();

            // Initialize product object as form property to use it during elements generation
            $form->setDataObject(Mage::registry('group_data'));

            $fieldset = $form->addFieldset('group_fields' . $group->getId(), array(
                'legend' => Mage::helper('banner')->__($group->getAttributeGroupName()),
                'class' => 'fieldset-wide'
            ));

            $attributes = $this->getGroupAttributes();
           
            $this->_setFieldset($attributes, $fieldset, array('gallery'));

            $values = Mage::registry('group_data')->getData();

            // Set default attribute values for new product
            if (!Mage::registry('group_data')->getId()) {
                foreach ($attributes as $attribute) {
                    if (!isset($values[$attribute->getAttributeCode()])) {
                        $values[$attribute->getAttributeCode()] = $attribute->getDefaultValue();
                    }
                }
            }

            if (Mage::registry('group_data')->hasLockedAttributes()) {
                foreach (Mage::registry('group_data')->getLockedAttributes() as $attribute) {
                    $element = $form->getElement($attribute);
                    if ($element) {
                        $element->setReadonly(true, true);
                    }
                }
            }
            $form->addValues($values);

            // $form->setFieldNameSuffix('product');
            // Mage::dispatchEvent('adminhtml_catalog_product_edit_prepare_form', array('form' => $form));

            $this->setForm($form);
        }
    }

    /**
     * Retrieve additional element types
     *
     * @return array
     */
    protected function _getAdditionalElementTypes()
    {
        $result = array(
            'gallery'  => Mage::getConfig()->getBlockClassName('banner/adminhtml_group_edit_tab_form_gallery'),
            // 'image'    => Mage::getConfig()->getBlockClassName('banner/catalog_product_helper_form_image'),
        );

        $response = new Varien_Object();
        $response->setTypes(array());
        Mage::dispatchEvent('adminhtml_catalog_product_edit_element_types', array('response' => $response));

        foreach ($response->getTypes() as $typeName => $typeClass) {
            $result[$typeName] = $typeClass;
        }

        return $result;
    }
}