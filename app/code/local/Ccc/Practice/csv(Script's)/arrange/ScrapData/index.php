<?php

class Data
{
    protected $_data = array();
    protected $_dataFinal = array();
    protected $_attributes = array();
    protected $_header = array();
    protected $_file = 'scrap-data.csv';
    protected $_fileReport = 'scrap-attribute-count.csv';
        
    protected function _loadFile()
    {
        $handler = fopen($this->_file, "r");
        if($handler)
        {
            $rowCnt = 0;
            while($row = fgetcsv($handler, 15000, ",", "\""))
            {
                if($rowCnt == 0)
                {
                    $this->_header = $row;
                    $rowCnt = 1;
                }
                else
                {
                    $this->_data[] = array_combine($this->_header, $row);
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
        try
        {
            $this->_loadFile();
            $this->_formatData();
            $this->_generateReport();
            echo "DONE";
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        
        
    }
    
    protected function _formatData()
    {
        if(!$this->_data)
        {
            throw new Exception("Postals are not available");
        }
        
        if(count($this->_data))
        {
            $data = array();
            foreach($this->_data as $attribute)
            {
                if(!isset($data[$attribute["Attribute Title"]]))
                {
                    $data[$attribute["Attribute Title"]][] = $attribute["Category"]; 
                }
                else
                {
                    if(!in_array($attribute["Category"],$finalData[$attribute["Attribute Title"]]))
                    {
                        $data[$attribute["Attribute Title"]][] = $attribute["Category"];
                    }
                }        
            }   
        }
        $data = array_map("array_unique",$data);
        if(count($data))
        {
            $this->_dataFinal = array();
            foreach($data as $attribute => $_data)
            {
                $this->_dataFinal[] = array($attribute,count($_data));
            }
        }
    }
    
    protected function _generateReport()
    {   
        if($this->_dataFinal)
        {   
            //$handler = fopen($this->_fileReport, "w"); 
            $handler = fopen($this->_fileReport, 'w'); 
            
            if($handler)
            {   
                $cnt = 0;
                foreach($this->_dataFinal as $key => $_data)
                {
                    if($cnt==0)
                    {
                        fputcsv($handler, array("Attrbute Name","Count"), ",", "\"");
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