<?php 

class Sonali_Sonali_Block_Adminhtml_Sonali_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
        parent::__construct();
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('sonali')->__('Sonali Information'));
	}

	public function getSonali()
    {
        return Mage::registry('current_sonali');
    }

    protected function _beforeToHtml()
    {
        $sonali = Mage::registry('current_sonali');
        $setModel = Mage::getModel('eav/entity_attribute_set');

        if (!($setId = $sonali->getAttributeSetId())) {
            $setId = $this->getRequest()->getParam('set', null);
        }

        if ($setModel->load($setId)->getAttributeSetId()) {
            
            $sonaliAttributes = Mage::getResourceModel('sonali/sonali_attribute_collection');

            if (!$sonali->getId()) {
                foreach ($sonaliAttributes as $attribute) {
                    $default = $attribute->getDefaultValue();
                    if ($default != '') {
                        $sonali->setData($attribute->getAttributeCode(), $default);
                    }
                }
            }

            $groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
                ->setAttributeSetFilter($setId)
                ->setSortOrder()
                ->load();

            $defaultGroupId = 0;
            foreach ($groupCollection as $group) {
                if ($defaultGroupId == 0 or $group->getIsDefault()) {
                    $defaultGroupId = $group->getId();
                }

            }	

            foreach ($groupCollection as $group) {
                $attributes = array();
                foreach ($sonaliAttributes as $attribute) {
                    if ($sonali->checkInGroup($attribute->getId(),$setId, $group->getId())) {
                        $attributes[] = $attribute;
                    }
                }

                if (!$attributes) {
                    continue;
                }

                $active = $defaultGroupId == $group->getId();
                $block = $this->getLayout()->createBlock('sonali/adminhtml_sonali_edit_tab_attributes')
                    ->setGroup($group)
                    ->setAttributes($attributes)
                    ->setAddHiddenFields($active)
                    ->toHtml();

                $this->addTab('group_' . $group->getId(), array(
                    'label'     => Mage::helper('sonali')->__($group->getAttributeGroupName()),
                    'content'   => $block,
                    'active'    => $active
                ));
            }
        } else {
            $this->addTab('set', array(
                'label'     => Mage::helper('sonali')->__('Settings'),
                'content'   => $this->_translateHtml($this->getLayout()
                    ->createBlock('sonali/adminhtml_sonali_edit_tab_setting')->toHtml()),
                'active'    => true
            ));
        }
      return parent::_beforeToHtml();
    }

    protected function _translateHtml($html)
    {
        Mage::getSingleton('core/translate_inline')->processResponseBody($html);
        return $html;
    }
}