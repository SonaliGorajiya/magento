<?php

class Sonali_Idx_Block_Adminhtml_Idx_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/import'),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $form->addField('csv', 'file', array(
            'name'      => 'csv',
            'label'     => $this->__('CSV File'),
            'title'     => $this->__('CSV File'),
            'required'  => true,
        ));

        $this->setForm($form);
        return parent::_prepareLayout();
    }

}





    