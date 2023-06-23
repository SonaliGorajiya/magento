<?php
class Data
{
    protected $_data = array();
    protected $_dataFinal = array();
    protected $_dataError = array();
   
    protected $_header = array();
    
    protected $_folderPath = 'html';
    protected $_fileReport = 'report.csv';
    protected $_errorReport = 'error_report.csv';
        
    protected function _loadFile()
    {
        /*$files = glob($this->_folderPath);

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
        }*/

        $this->_data = $this->readDir($this->_folderPath);

    }  

    function readDir($dir,$prefix = '')
    {
        $dir = rtrim($dir, '\\/');
        $result = array();    
        if(!is_dir($dir))
        {
            return $result;
        }

        if($directory = opendir($dir))
        {
            while(($file = readdir($directory)) !== false)
             {
                 if($file !== '.' and $file !== '..')
                 {
                     if (is_dir("$dir/$file"))
                     {
                        $result = array_merge($result, $this->readDir("$dir/$file","$prefix/$file"));
                     } 
                     else 
                     {
                        $result[] = array(
                            "path" => ltrim($prefix, '/'),
                            "file" => $file
                        );
                     }
                 }     
            }   
        }
        
        closedir($directory);
        return $result;
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
           $this->_dataFinal = $this->_data;
        }
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