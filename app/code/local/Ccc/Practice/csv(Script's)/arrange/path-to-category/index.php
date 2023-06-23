<?php

function trimStr($str)
{   
    $str = utf8_encode($str);
    $str = trim($str);
    return ucwords($str);
}

class Postal
{
    protected $_data = array();
    protected $_categoryTree = array();
    
    protected $_headerReport = array("INDEX","NAME","NAME PATH", "PARENT PATH", "FULL PATH");
    #protected $_headerReport = array("ORIGINAL","CATEGORY");
    protected $_header = array();
    protected $_file = 'postal.csv';
    protected $_fileReport = 'postal-report.csv';
        
    protected function _loadFile()
    {
        $handler = fopen($this->_file, "r");
        if($handler)
        {
            while($row = fgetcsv($handler, 4096, ",", "\""))
            {
                if(!$this->_header)
                {
                    $this->_header = $row;
                }
                else
                {
                    $row = array_combine($this->_header, $row);
                    $this->_data[] =  $row["category"];
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
        $this->_formatTree();
        $this->_generateReport();
        
        echo "DONE";
        
    }
    
    protected function _formatTree()
    {
        if(!$this->_data)
        {
            throw new Exception("Postals are not available");
        }
        
        $index=1;
        foreach($this->_data as $key =>$val)
        {
            if(!$val)
            {
                continue;
            }
            
            $keyArrayTmp = explode("/", $val);
            
            for($i=0; $i<count($keyArrayTmp);$i++)
            {
                $keyArray = array_map("trimStr", $keyArrayTmp);
                
                $category = implode("/", $keyArray);
                $name = isset($keyArray[$i]) ? $keyArray[$i] : "";   
                
                $parentPath = array_slice($keyArray, 0, isset($keyArray[$i-1]) ? $i : 0);
                if($parentPath)
                {
                    $parentPath =  implode("/", $parentPath);
                }
                else
                {
                    $parentPath = "";
                }
                
                $treeKey = $parentPath.'/'.$name;
                if(array_key_exists($treeKey, $this->_categoryTree))
                {
                    continue;
                }
                
                  $this->_categoryTree[$treeKey] = array(
                    "index"=>$index,
                    "name"=> $name,
                    "name_path"=> $treeKey,
                    "parentPath"=> $parentPath,
                    "full_path"=> $category
                );
                
                $index++;      
                
                
            }
        }
    }
    
    protected function _generateReport()
    {   
        //print_r($this->_categoryTree);
        
        if($this->_categoryTree)
        {
            $handler = fopen($this->_fileReport, "a"); 

            if($handler)
            {   
                fputcsv($handler, $this->_headerReport, ",", "\"");
                
                foreach($this->_categoryTree as $tree)
                {
                    fputcsv($handler, $tree, ",", "\"");
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

$obj = new Postal();
$obj->run();

?>