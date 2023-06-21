<?php
class Ccc_Practice_Block_Adminhtml_Seven extends Mage_Adminhtml_Block_Widget_Grid_Container
{

   
    public function __construct()
    {
        
        $this->_blockGroup = 'practice';
        $this->_controller = 'adminhtml_seven';
        $this->_headerText = Mage::helper('practice')->__('Query Seven');

        $this->_addButton('back', array(
            'label'     => $this->__('Back'),
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/index') . '\')',
            'class'     => 'back',
        ));
        
        parent::__construct();
        $this->_updateButton('add', 'label', $this->__('View Query'));


    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/viewseven');
    }

}