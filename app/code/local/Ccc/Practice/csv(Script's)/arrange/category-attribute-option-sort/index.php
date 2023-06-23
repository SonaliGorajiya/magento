<?php
ini_set('memory_limit','512M');

class Data
{
    protected $_data = array();
    protected $_header = array();
    
    protected $_attributeData = array();
    protected $_attributeHeader = array();
    
    protected $_dataFinal = array();
    
    protected $_attributeFile = 'attribute.csv';
    protected $_file = 'data.csv';
    protected $_fileReport = 'data-report.csv';
        
    protected function _loadFile()
    {
        $handler = fopen($this->_attributeFile, "r");
        if($handler)
        {
            $rowCnt = 0;
            while($row = fgetcsv($handler, 4096, ",", "\""))
            {
                if(!$this->_attributeHeader)
                {
                    $this->_attributeHeader = $row;
                }
                else
                {
                    $row = array_combine($this->_attributeHeader, $row);
                    $this->_attributeData[] = $row;
                }
            }    
            fclose($handler);
        }
        else
        {
            throw new Exception("Unable to open file");     
        }
        
        $handler = fopen($this->_file, "r");
        if($handler)
        {
            $rowCnt = 0;
            while($row = fgetcsv($handler, 4096, ",", "\""))
            {
                if(!$this->_header)
                {
                    $this->_header = $row;
                }
                else
                {
                    $row = array_combine($this->_header, $row);
                    $this->_data[] = $row;
                }
            }    
            fclose($handler);
        }
        else
        {
            throw new Exception("Unable to open file");     
        }
        
    }
    
    public function run()
    {   
        echo "<pre>"; 
        $this->_loadFile();
        $this->_formatData();
        $this->_generateReport();
        
        echo "DONE";
        
    }
    
    protected function _formatData()
    {
        if(!$this->_data)
        {
            throw new Exception("Data is not available");
        }
        
        if(!$this->_categoryData)
        {
            throw new Exception("Category data is not available");
        }
        
        foreach($this->_categoryData as $_category)
        {
            foreach($this->_data as $row)
            {
                $row["category"] = $_category["category"];
                $this->_dataFinal[] = $row;       
            }
        }
    }
    
    protected function _generateReport()
    {   
        if($this->_dataFinal)
        {
            $handler = fopen($this->_fileReport, "a"); 
            
            if($handler)
            {   
                $cnt = 0;
                foreach($this->_dataFinal as $key => $_data)
                {
                    if($cnt==0)
                    {
                        fputcsv($handler, array_keys($_data), ",", "\"");
                        $cnt++;
                    }
                    
                    fputcsv($handler, $_data, ",", "\"");
                }
                
                fclose($handler);
            }
            else
            {
                throw new Exception("Unable to open file to write");     
            }
        }
    }    
}

$obj = new Data();
$obj->run();

?>