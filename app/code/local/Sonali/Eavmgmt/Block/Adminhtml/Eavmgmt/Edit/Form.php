<?php

class Sonali_Eavmgmt_Block_Adminhtml_Eavmgmt_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/import/importoptions', array('id' => $this->getRequest()->getParam('eavmgmt_id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}



    