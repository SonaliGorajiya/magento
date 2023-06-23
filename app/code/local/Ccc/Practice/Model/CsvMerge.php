<?php 
ini_set('memory_limit','512M');
class Ccc_Practice_Model_CsvMerge extends Mage_Core_Model_Abstract
{
    protected $_optionData = array();
    protected $_header = array();
    
    protected $_categoryData = array();
    protected $_categoryHeader = array();
    
    protected $_dataFinal = array();
    
    protected $_categoryFile = null;
    protected $_file = null;
    protected $_fileReport = null;
            
    public function setCategoryFile(String $file)
    {
        $this->_categoryFile = $file;
        return $this; 
    }

    public function setOptionFile(String $file)
    {
        $this->_file = $file;
        return $this; 
    }

    public function setFinalFile(String $file)
    {
        $this->_fileReport = $file;
        return $this; 
    }

    protected function _loadFile()
    {
        $model = new Varien_File_Csv();

        if($categories = $model->getData($this->_categoryFile))
        {
            foreach($categories as $category)
            {
                if(!$this->_categoryHeader)
                {
                    $this->_categoryHeader = $category;
                }
                else
                {
                    $category = array_combine($this->_categoryHeader, $category);
                    $this->_categoryData[$category["CATEGORY"]] = $category["CATEGORY"];
                }
            }    
        }
        else
        {
            throw new Exception("Unable to open file");     
        }

        if($attributeOptions = $model->getData($this->_file))
        {
            foreach($attributeOptions as $row)
            {
                if(!$this->_header)
                {
                    $this->_header = $row;
                }
                else
                {
                    $attributeOption = array_combine($this->_header, $row);
                    $this->_optionData[$attributeOption["ATTRIBUTE"]][$attributeOption["OPTION"]] = $attributeOption["OPTION"];
                }
            }    

        }
        else
        {
            throw new Exception("Unable to open file");     
        }
    }
    
    public function run()
    {   
        $this->_loadFile();
        $this->_formatData();
        $this->_generateReport();
        return $this->_fileReport; 
    }
    
    protected function _formatData()
    {
        if(!$this->_optionData)
        {
            throw new Exception("Data is not available");
        }
        
        if(!$this->_categoryData)
        {
            throw new Exception("Category data is not available");
        }
        foreach($this->_categoryData as $_category)
        {

            foreach($this->_optionData as $attribute => $options)
            {
                $tmp = array(
                    "CATEGORY" => $_category, 
                    "ATTRIBUTE" => $attribute
                );
                
                foreach($options as $option)
                {
                    $tmp["OPTION"] = $option;
                    $this->_dataFinal[] = $tmp;
                }
            }
        }
    }
    
    protected function _generateReport()
    {   
        $finalOutput[] = array_keys($this->_dataFinal[0]);
        foreach ($this->_dataFinal as $element) {
            $finalOutput[] = array_values($element);
        }

        $this->_dataFinal = $finalOutput;
    }     
}

?>