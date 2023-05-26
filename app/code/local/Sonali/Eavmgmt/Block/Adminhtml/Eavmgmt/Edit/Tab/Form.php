<?php
class Sonali_Eavmgmt_Block_Adminhtml_Eavmgmt_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$eavmgmtField = $form->addFieldset('eavmgmt_form',array('legend'=>Mage::helper('eavmgmt')->__('Eavmgmt Information')));


		$eavmgmtField->addField('name', 'text', array(
            'label' => Mage::helper('eavmgmt')->__('Eavmgmt Name'),
            'required' => true,
            'name' => 'name',
		));

		$eavmgmtField->addField('status', 'select', array(
            'label' => Mage::helper('eavmgmt')->__('Status'),
            'required' => true,
            'name' => 'status',
            'type' => 'select',
            'options' => array(
            	'1' => Mage::helper('eavmgmt')->__('Active'),
            	'2' => Mage::helper('eavmgmt')->__('Inactive')
            )
		));

		$eavmgmtField->addField('description', 'text', array(
            'label' => Mage::helper('eavmgmt')->__('Description'),
            'required' => true,
            'name' => 'description',
		));

		if ( Mage::getSingleton('adminhtml/session')->geteavmgmtData() )
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->geteavmgmtData());
			Mage::getSingleton('adminhtml/session')->seteavmgmtData(null);
		} 
		elseif ( Mage::registry('eavmgmt_data') ) 
		{
			$form->setValues(Mage::registry('eavmgmt_data')->getData());
		}
		return parent::_prepareForm();
	}
}
