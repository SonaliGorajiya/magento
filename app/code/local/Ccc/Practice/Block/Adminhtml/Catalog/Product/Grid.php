<?php

class Ccc_Practice_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    public function _prepareColumns()
    {
        parent::_prepareColumns();

        // $this->removeColumn('price');
    }
}
