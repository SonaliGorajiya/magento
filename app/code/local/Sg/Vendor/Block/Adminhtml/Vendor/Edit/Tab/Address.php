<?php
class Sg_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Address extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('vendor_form',array('legend'=>Mage::helper('vendor')->__('Vendor Address information')));


		 $fieldset->addField('address', 'text', array(
            'label' => Mage::helper('vendor')->__('Address'),
            'name' => 'vendor_address[address]',
            'required' => true,
        ));

        $fieldset->addField('postal_code', 'text', array(
            'label' => Mage::helper('vendor')->__('Postal Code'),
            'name' => 'vendor_address[postal_code]',
            'required' => true,
        ));

        $fieldset->addField('city', 'text', array(
            'label' => Mage::helper('vendor')->__('City'),
            'name' => 'vendor_address[city]',
            'required' => true,
        ));


   
        $fieldset->addField('country', 'select', array(
            'name'      => 'vendor_address[country]',
            'label'     => Mage::helper('vendor')->__('Country'),
            'required'  => true,
            'values'    => Mage::getModel('directory/country')->getResourceCollection()
                            ->loadByStore()
                            ->toOptionArray(),
            'onchange'  => 'updateStateOptions(this.value)',
        ));

        $fieldset->addField('state', 'select', array(
            'name'      => 'vendor_address[state]',
            'label'     => Mage::helper('vendor')->__('State'),
            'required'  => true,
            'values'    => Mage::getModel('directory/region')->getResourceCollection()
                            ->addCountryFilter($countryId)
                            ->load()
                            ->toOptionArray()
        ));
        
        
        $script = '
            <script>
            function updateStateOptions(countryId) {
                console.log(countryId);
                var url = "' . $this->getUrl('*/*/updateStateOptions') . '"; // Replace with your controller action URL
                new Ajax.Request(url, {
                    method: "post",
                    parameters: { country_id: countryId },
                    onSuccess: function(transport) {
                        var response = transport.responseText.evalJSON();
                        var stateField = $("state");
                        stateField.update("");
                        response.each(function(option) {
                            stateField.insert(new Element("option", { value: option.value }).update(option.label));
                        });
                    }
                });
            }
            </script>';
        $fieldset->addField('ajax_script', 'note', array(
            'text'     => $script,
            'after_element_html' => '',
        ));

    
		if ( Mage::getSingleton('adminhtml/session')->getsalesmanData() )
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getsalesmanData());
			Mage::getSingleton('adminhtml/session')->setsalesmanData(null);
		} 
		elseif ( Mage::registry('address_data') ) 
		{
			$form->setValues(Mage::registry('address_data')->getData());
		}
		return parent::_prepareForm();
	}
}
