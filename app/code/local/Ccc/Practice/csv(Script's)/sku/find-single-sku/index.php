<?php
ini_set('memory_limit','512M');

class Data
{
    protected $_data = array();
    protected $_header = array();
    
    protected $_dataFinal = array();
    
    protected $_file = 'data.csv';
    protected $_fileReport = 'report.csv';
        
    protected function _loadFile()
    { 
        $handler = fopen($this->_file, "r");
        if($handler)
        {
            $rowCnt = 0;
            $previousPrimary = 1;
            while($row = fgetcsv($handler, 4096, ",", "\""))
            {
                if(!$this->_header)
                {
                    $this->_header = $row;
                }
                else
                {
                    $row = array_combine($this->_header, $row);

                    if($row["primary"] == '')
                    {
                        $row["primary"] = $previousPrimary;
                    }
                    //$this->_data[$row["primary"]][$row["sku"]] = $row;
                    $this->_data[$row["primary"]][] = $row;
                    $previousPrimary = $row["primary"];
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

        $i = 1;
        foreach ($this->_data as $primary => $row) 
        {
            $skuArray = array();
            foreach ($row as $sku => $value) 
            {
                $skuArray[] = $value['sku'];
            }
            sort($skuArray);
            $newsku = implode(";", $skuArray);
            $this->_dataFinal[] = array(
                "INDEX" => $i++,
                "primary" => $primary,
                "sku" => $newsku
            );
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