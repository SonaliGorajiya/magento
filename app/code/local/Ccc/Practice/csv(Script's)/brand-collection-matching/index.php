<?php
ini_set('memory_limit','512M');

class Data
{
    protected $_live = 'live.csv';
    protected $_liveData = array();
    protected $_liveHeader = array();
    
    protected $_local = 'local.csv';
    protected $_localData = array();
    protected $_localHeader = array();
    
    protected $_dataFinal = array();
    
    protected $_fileReport = 'report.csv';
        
    protected function _loadFile()
    {
        $handler = fopen($this->_local, "r");
        if($handler)
        {
            $rowCnt = 0;
            while($row = fgetcsv($handler, 4096, ",", "\""))
            {
                if(!$this->_localHeader)
                {
                    $this->_localHeader = $row;
                }
                else
                {
                    $row = array_combine($this->_localHeader, $row);

                    if(!array_key_exists($row["brand"], $this->_localData))
                    {
                    	$this->_localData[$row["brand"]]= array();
                    }

                    $this->_localData[$row["brand"]][$row["collection"]] = 1;
                }
            }    
            fclose($handler);
        }
        else
        {
            throw new Exception("Unable to open file");     
        }
        
        $handler = fopen($this->_live, "r");
        if($handler)
        {
            $rowCnt = 0;
            while($row = fgetcsv($handler, 4096, ",", "\""))
            {
                if(!$this->_liveHeader)
                {
                    $this->_liveHeader = $row;
                }
                else
                {
                    $row = array_combine($this->_liveHeader, $row);
                    
                    if(!array_key_exists($row["brand"], $this->_liveData))
                    {
                    	$this->_liveData[$row["brand"]]= array();
                    }

                    $this->_liveData[$row["brand"]][$row["collection"]] = 1;

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
        $this->_compareData();
        $this->_generateReport();
        
        echo "DONE";
        
    }
    
    protected function _compareData()
    {
        if(!$this->_liveData)
        {
            throw new Exception("Live Data is not available");
        }

        if(!$this->_localData)
        {
            throw new Exception("Local Data is not available");
        }
        
        foreach($this->_liveData as $_brand => $collections)
        {
            if(!array_key_exists($_brand, $this->_localData))
            {
            	$this->_dataFinal[] = array(
            		"brand" => $_brand,
            		"collection" => "", 
            		"status" => "BRAND ISSUE"
            	);

            	continue;
            }

            foreach($collections as $_collection => $value)
            {
            	if(!array_key_exists($_collection, $this->_localData[$_brand]))
	            {
	            	$this->_dataFinal[] = array(
	            		"brand" => $_brand,
	            		"collection" => $_collection, 
	            		"status" => "COLLECTION ISSUE"
	            	);
	            }
            }
        }

        //print_r($this->_dataFinal);die;

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