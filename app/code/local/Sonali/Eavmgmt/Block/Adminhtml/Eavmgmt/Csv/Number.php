<?php

class Sonali_Eavmgmt_Block_Adminhtml_Eavmgmt_Csv_Number extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract		
{
	public $index = 0;
	
	public function render($row)
	{
		$this->setIndex($this->getIndex()+1);
		return $this->getIndex();
	}

    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }
}