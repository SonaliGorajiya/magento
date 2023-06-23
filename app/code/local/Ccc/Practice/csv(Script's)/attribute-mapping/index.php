<?php

class Data
{
    protected $_data = array();
    protected $_dataFinal = array();
    protected $_optionDataFinal = array();
    protected $_attributes = array();
    protected $_header = array();
    protected $_optionHeaderTitle = array();
    protected $_headerTitle = array();
    protected $_file = 'data.csv';
    protected $_fileReport = 'category-attribute-mapping.csv';
    protected $_optionFileReport = 'category-attribute-mapping-option.csv';
    protected $_ingnoreAttributeTitle = array('Get It Fast','Brand','Customer Rating','Availability','Name','Price','Weight');
        
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
            $this->_generateOptionReport();
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
          
            $i = 1; 
            foreach($this->_data as $attribute)
            {      
                    if(in_array($attribute['Attribute Title'], $this->_ingnoreAttributeTitle))
                    {
                       continue;
                    }

                    if(!isset($data[$attribute['Full Path']][$attribute['Attribute Title']]) && !empty($attribute['Attribute Title']))
                    {
                        $data[$attribute['Full Path']][$attribute['Attribute Title']] = $attribute['Full Path'];

                        $this->_dataFinal[$i]['category'] = $attribute['Full Path'];
                        $this->_dataFinal[$i]['attribute_code'] = $attribute['Attribute Title'];
                        $this->_dataFinal[$i]['sort_order'] = $attribute['Attribute Order'];
                        $this->_dataFinal[$i]['used_for_main_item'] = 1;
                        $this->_dataFinal[$i]['name_order'] = 1;
                        $this->_dataFinal[$i]['is_disable'] = 0;
                        $this->_dataFinal[$i]['important'] = 1;
                        $this->_dataFinal[$i]['predefined'] = 1;
                     }

                     $this->_optionDataFinal[$i]['category'] = $attribute['Full Path'];
                     $this->_optionDataFinal[$i]['attribute_code'] = $attribute['Attribute Title'];
                     $this->_optionDataFinal[$i]['option'] = $attribute['New Option'];
                     $this->_optionDataFinal[$i]['sort_order'] = $attribute['Attribute Order'];
                     $this->_optionDataFinal[$i]['is_disable'] = 0;
                     $this->_optionDataFinal[$i]['predefined'] = 1;
                     
                     $i++;
            }

            /*echo count($this->_data);
            echo "<br>";
            echo count($data);
            echo "<pre>";
            print_r($this->_optionDataFinal);
            exit;*/
        }

    }
    
    public function getHeaderTitle(){
         $this->_headerTitle = array('category','attribute_code','sort_order','used_for_main_item','name_order','is_disable','important','predefined');
         return $this->_headerTitle;
    } 

    public function getOptionHeaderTitle(){
         $this->_optionHeaderTitle = array('category','attribute_code','option','sort_order','is_disable','predefined');
         return $this->_optionHeaderTitle;
    }

    protected function _generateReport()
    {   
        if($this->_dataFinal)
        {   
            
            $handler = fopen($this->_fileReport, 'w'); 
            
            if($handler)
            {   
                $cnt = 0;
                $i = 1;
                foreach($this->_dataFinal as $key => $_data)
                {
                    if($cnt==0)
                    {
                        $headerTitle = $this->getHeaderTitle();
                        array_unshift($headerTitle, "INDEX");
                        fputcsv($handler, $headerTitle, ",", "\"");
                        $cnt++;
                    }

                    array_unshift($_data, $i);
                    fputcsv($handler, $_data, ",", "\"");
                    $i++;
                }
                
                fclose($handler);
            }
            else
            {
                throw new Exception("Unable to open file to write");     
            }
        }
    }  

    protected function _generateOptionReport()
    {   
        if($this->_optionDataFinal)
        {   
            
            $handler = fopen($this->_optionFileReport, 'w'); 
            
            if($handler)
            {   
                $cnt = 0;
                $i = 1;
                foreach($this->_optionDataFinal as $key => $_data)
                {
                    if($cnt==0)
                    {
                        $headerTitle = $this->getOptionHeaderTitle();
                        array_unshift($headerTitle, "INDEX");
                        fputcsv($handler, $headerTitle, ",", "\"");
                        $cnt++;
                    }

                    array_unshift($_data, $i);
                    fputcsv($handler, $_data, ",", "\"");
                    $i++;
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