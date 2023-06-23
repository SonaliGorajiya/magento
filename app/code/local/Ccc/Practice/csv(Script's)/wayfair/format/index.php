<?php
class Data
{
    protected $_data = array();
    protected $_dataFinal = array();
    protected $_attributes = array();
    protected $_header = array();
    protected $_file = 'data.csv';
    protected $_fileReport = 'report.csv';
        
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

            $this->_header[] = 'Origanl breadcrumbs';
            foreach($this->_data as $attribute)
            {      


                    $furniquePosition = strpos($attribute['Category breadcrumbs Text'], 'Furniture/');
                    
                    $breadcrumbsOri = (isset($attribute['Category breadcrumbs Text']))?$attribute['Category breadcrumbs Text']:'';
                    $categoryOri = (isset($attribute['Category']))?'/'.$attribute['Category']:'';
                    $attribute['origanl_breadcrumbs'] = $breadcrumbsOri."".$categoryOri;
                    if(isset($furniquePosition) && $furniquePosition === 0)
                    {
                        //$attribute['Category breadcrumbs Text'] = str_replace("Furniture/", " ", $attribute['Category breadcrumbs Text']);
                        $attribute['Category breadcrumbs Text'] = ltrim($attribute['Category breadcrumbs Text'],"Furniture/");
                    }

                    if(isset($attribute['Category breadcrumbs Text']))
                    {
                        $attribute['Category breadcrumbs Text'] = str_replace("'", "", $attribute['Category breadcrumbs Text']);
                        $attribute['Category breadcrumbs Text'] = str_replace('"', '', $attribute['Category breadcrumbs Text']);
                        if(empty($attribute['Category breadcrumbs Text']) || $attribute['Category breadcrumbs Text'] == '')
                        {
                            $attribute['Category breadcrumbs Text'] = (isset($attribute['Title']))?$attribute['Title']:'';
                        }
                    }

                    if(isset($attribute['Category']))
                    {
                        $attribute['Category'] = str_replace("'", "", $attribute['Category']);
                        $attribute['Category'] = str_replace('"', '', $attribute['Category']);
                    }

                    $value = implode("|", $attribute);
                    $value = htmlspecialchars_decode($value);
                    $value = str_replace("W/ ", "With", $value);
                    $value = str_replace("A/V", "A-V", $value);
                    $value = str_replace("DÃ©cor", "Decor", $value);
                    $value = str_replace("Décor", "Decor", $value);
                    $value = str_replace("&#039;", "", $value);
                    $value = str_replace("&nbsp;", "", $value);
                    $value = str_replace("&raquo;", "", $value);
                    $value = str_replace("&#x27;", "", $value);

                    $data = array_combine($this->_header, explode("|", $value));

                    $data = $this->getFullPathOfCategory($data);

                    $data =  array_map('trim', $data);
                    if(isset($data['Attribute Option']))
                    {
                        $data = $this->getAttributeOption($data);    
                    }

                    $this->_dataFinal[] = $data;
            }
        }
    }

    public function getFullPathOfCategory($data){
        
        if(isset($data['Attribute Option']))
        {
            $full_path = $data['Category breadcrumbs Text'];
        }
        else
        {
            /*if(!empty($data['Category breadcrumbs Text']))
            {*/
                $full_path = $data['Category breadcrumbs Text']."/".$data['Category'];
            /*}
            else
            {
                $full_path = $data['Title']."/".$data['Category'];
            }*/   
        }

        $data['full_path'] = $full_path;
        return $data;
    }

    public function getAttributeOption($data){
        
       $result = strpos($data['Attribute Option'], '(');

        if(is_bool($result) && $result == false)
        {
            $data['new_option'] = trim($data['Attribute Option']);
            $data['option_result'] = "0";
        }
        else if($result >= 0)
        {
            $data['new_option'] = substr($data['Attribute Option'], 0, strrpos($data['Attribute Option'], '(') ); //
            $data['option_result'] = str_replace($data['new_option'], "", $data['Attribute Option']);
            $data['option_result'] = ltrim($data['option_result'],"(");
            $data['option_result'] = rtrim($data['option_result'],")");
            $data['new_option'] = trim($data['new_option']);
        }
        $data['new_option'] = $this->validateOptionAndGetUpdatedOption($data['new_option']);
        return $data;
    }
    
    public function validateOptionAndGetUpdatedOption($optionValue)
    {
        $optionValue = trim($optionValue);
        $optionValue = explode("-", $optionValue);
        $optionValue = array_map("trim",$optionValue);
        $optionValue = trim(implode(" - ", $optionValue), " - ");
        $optionValue = explode("/", $optionValue);
        $optionValue = array_map("trim",$optionValue);
        $optionValue = trim(implode(" / ", $optionValue), " / ");
        $optionValue = ucwords($optionValue);
        $optionValue = preg_replace('/\s+/', ' ',$optionValue);
        return $optionValue;
    }

    public function getHeaderTitle(){

         $this->_header[] = 'Full Path';
         if(in_array('Attribute Option', $this->_header)){
             $this->_header[] = 'New Option';
             $this->_header[] = 'Option Result';
         }
         return $this->_header;
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
}

$obj = new Data();
$obj->run();

?>