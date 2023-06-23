<?php

class Data
{
    protected $_data = array();
    protected $_attribute = array();
    protected $_dataFinal = array();
    
    protected $_header = array();
    protected $_file = 'data.csv';
    protected $_fileReport = 'data-report.csv';
        
    protected function _loadFile()
    {
        /*echo "<pre>";
        
        print_r($this->_attributeIndex);die;*/
        
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
                    
                    if(!array_key_exists($row["attribute_code"], $this->_data))
                    {
                        $this->_data[$row["attribute_code"]] = array();
                    }
                    
                    $this->_data[$row["attribute_code"]][] = $row["option"];
                    //$this->_attribute[$row["attribute_code"]][] = $row["option"]
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
            throw new Exception("Postals are not available");
        }

        $cnt = 1;
        foreach ($this->_data as $key => $value) 
        {
            sort($value);
            $this->_data[$key] = $value;

            $sortOrder = 1;
            foreach ($this->_data[$key] as $val) 
            {
                $this->_dataFinal[] = array(
                    'INDEX' => $cnt,
                    'attribute_code' => $key,
                    'option'=> $val,
                    'sort_order' => $sortOrder
                );

                $cnt++;
                $sortOrder++;
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