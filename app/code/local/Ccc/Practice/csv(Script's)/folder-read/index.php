<?php
class Data
{
    protected $_data = array();
    protected $_dataFinal = array();
    protected $_dataError = array();
   
    protected $_header = array();
    
    protected $_folderPath = 'html/*';
    protected $_fileReport = 'report.csv';
    protected $_errorReport = 'error_report.csv';
        
    protected function _loadFile()
    {
        $files = glob($this->_folderPath);

        if($files)
        {
        	foreach ($files as $key => $file) 
        	{
        		$row['file_name'] = $file;
        		$this->_data[] = $row;
        	}
        }
        else
        {
            throw new Exception("Unable to open file");     
        }

        print_r($this->_data);
        die;
    }
    
    public function run()
    {   
        try
        {
            echo '<pre>';
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
            throw new Exception("Data are not available");
        }

        if(count($this->_data))
        {
            foreach($this->_data as $_data)
            {
                $fileName = $_data['file_name'];

                if(!file_exists($fileName))
                {
                    $_data['status'] = 'MISSING FILE';
                    $this->_dataError[] = $_data;
                }
                else
                {
                    $this->_getFileData($fileName, $_data);
                }
            }
        }
    }

    protected function _getFileData($fileName, $_data)
    {
        $dom = new DOMDocument();
        $html = @$dom->loadHTMLFile($fileName);
        $dom->preserveWhiteSpace = false;  

        $finder = new DomXPath($dom);
        $classname = "product-preview";
        $productPreview = $finder->query("//*[contains(@class, '$classname')]");
        $_row = array();
        $i = 1;

        if($productPreview)
        {
            foreach ($productPreview as $key => $row)
            {
                $url = $row->getElementsByTagName('a');

                if($url->item(0))
                {
                	$_row['index'] = $i;
                	$_row['file_name'] = $fileName;
                	$_row['url'] = $url->item(0)->attributes->getNamedItem("href")->value;	
                	$this->_dataFinal[] = $_row;
                }
                $i++;
           }
        }

        return $this;
    }

    protected function _generateReport()
    {   
        if($this->_dataFinal)
        {
            $handler = fopen($this->_fileReport, 'w'); 
            
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

        if($this->_dataError)
        {
            if(file_exists($this->_errorReport))
            {
                unlink($this->_errorReport);
            }

            $handler = fopen($this->_errorReport, 'w'); 
            
            if($handler)
            {   
                $cnt = 0;
                
                foreach($this->_dataError as $key => $_data)
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
                throw new Exception("Unable to open report file to write");     
            }
        }
    }    
}

$obj = new Data();
$obj->run();

?>