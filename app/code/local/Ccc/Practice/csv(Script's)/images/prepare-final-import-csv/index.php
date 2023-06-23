<?php

class Postal
{
    protected $_data = array();
    protected $_dataFinal = array();
    
    protected $_headerReport = array();
    protected $_header = array();
    protected $_file = 'data.csv';
    protected $_fileReport = 'data-report.csv';
    
    public function run()
    {   
        echo "<pre>"; 
        $this->_loadFile();
        $this->_formatData();
        $this->_generateReport();
        
        echo "DONE";
        
    }
        
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
                    //$this->_data[] = $row;
                    
                    if(!array_key_exists($row["sku"], $this->_data))
                    {
                        $this->_data[$row["sku"]] = $row;
                    }
                    else
                    {
                        $this->_data[$row["sku"]]["images"] = $this->_data[$row["sku"]]["images"].",".$row["images"];
                    }
                    
                }
            }    
            fclose($handler);
        }
        else
        {
            throw new Exception("Unable to open file");     
        }
        
        //print_r($this->_data);die;
    }
    
    protected function _formatData()
    {   
        if(!$this->_data)
        {
            throw new Exception("No data available to process.");
        }
        
        foreach($this->_data as $data)
        {
            #$data = array("sku","image","thumbnail","small_image","_media_image","_media_attribute_id","_media_lable","_media_position","_media_is_disabled");
            
            $this->_dataFinal[$data["sku"]] = array();
            
            $images = explode(",", $data["images"]);
            
            if($images)
            {
                $cnt = 1;
                foreach($images as $_image)
                {
                    $_image = trim($_image);
                    
                    if(!$_image)
                    {
                        continue;
                    }
                    
                    $tmpArray = array();
                    if($cnt==1)
                    {
                        $tmpArray =  array(
                            "sku" => $data["sku"],
                            "image" => $_image,
                            "thumbnail" => $_image,
                            "small_image" => $_image,
                            "_media_image" => $_image,
                            "_media_attribute_id" => 88,
                            "_media_lable" => "",
                            "_media_position" => $cnt,
                            "_media_is_disabled" => 0
                        );
                    }
                    else
                    {
                        $tmpArray =  array(
                            "sku" => "",
                            "image" => "",
                            "thumbnail" => "",
                            "small_image" => "",
                            "_media_image" => $_image,
                            "_media_attribute_id" => 88,
                            "_media_lable" => "",
                            "_media_position" => $cnt,
                            "_media_is_disabled" => 0
                        );
                    }
                    
                    $cnt++;
                    $this->_dataFinal[$data["sku"]][] = $tmpArray;
                }
            }
        }
        
        //print_r($this->_dataFinal);die;
        
    }
    
    protected function _generateReport()
    {   
        if(!$this->_dataFinal)
        {
            throw new Exception("No data available to export."); 
        }
        
        $handler = fopen($this->_fileReport, "a"); 
        
        if($handler)
        {  
            $cnt = 0;
            foreach($this->_dataFinal as $data)
            {
                if(!$data)
                {
                    continue;
                }
                
                foreach($data as $row)
                {
                    if($cnt==0)
                    {
                        fputcsv($handler, array_keys($row), ",", "\"");
                        $cnt++;
                    }
                    
                    fputcsv($handler, $row, ",", "\"");
                }
            }
            
            fclose($handler);
        }
        else
        {
            throw new Exception("Unable to open file to write");     
        }
        
    }    
}

$obj = new Postal();
$obj->run();

?>