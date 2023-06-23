<?php
function trimStr($str)
{   
    $str = utf8_encode($str);
    $str = trim($str);
    return ucwords($str);
}

class Data
{
    protected $_data = array();
    protected $_categoryData = array();
    protected $_dataFinal = array();
    protected $_attributes = array();
    protected $_header = array();
    protected $_headerReport = array("INDEX","NAME","NAME PATH","PARENT PATH", "FULL PATH","CATEGORY URL","ORIGNAL BREADCRUMBS","TYPE","Has Item","Redirect To Category");
    protected $_file = 'data.csv';
    protected $_optionFile = 'data_option.csv';
    protected $_fileReport = 'catalog-category.csv';

    protected $_optionHeader = array();
    protected $_optionData = array();
    protected $_optionCategoryData = array();
    protected $_hasItemData = array();
    protected $_navigationData = array();
    protected $_navigationCategoryData = array();
    protected $_optionBreadCrumbData = array();
    protected $_navigationBreadCrum = array();

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
                    $data = array_combine($this->_header, $row);

                    $this->_navigationCategoryData[] = $data;
                    $this->_navigationData[$data['URL']] = $data['URL'];
                    $this->_navigationBreadCrum[strtolower($data['Category breadcrumbs Text'])] = $data['URL'];
                }
            }

            fclose($handler);
        }
        else
        {
            throw new Exception("Unable to open file");     
        }
    }
    
    protected function _loadOptionFile()
    {
        $handler = fopen($this->_optionFile, "r");
        if($handler)
        {
            $rowCnt = 0;
            while($row = fgetcsv($handler, 15000, ",", "\""))
            {
                if($rowCnt == 0)
                {
                    $this->_optionHeader = $row;
                    $rowCnt = 1;
                }
                else
                {
                    $data = array_combine($this->_optionHeader, $row);

                    $this->_optionCategoryData[] = $data;

                    $this->_optionData[$data['URL']] = $data['URL'];
                    $this->_hasItemData[$data['Category']] = $data['Category'];
                    $this->_optionBreadCrumbData[strtolower($data['Category breadcrumbs Text'])] = $data['Category breadcrumbs Text'];
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
            $this->_loadOptionFile();
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
            
            $cnt = 1 ;
            foreach($this->_data as $attribute)
            {      
                 if(!isset($data[$attribute['Full Path']]))
                 {
                     $data[$attribute['Full Path']] = $attribute['Full Path']; 
                     
                     $this->_categoryData[$cnt]['full_path'] = $attribute['Full Path']; 
                     $this->_categoryData[$cnt]['category_url'] = $attribute['Category URL']; 
                     $this->_categoryData[$cnt]['url'] = $attribute['URL']; 
                     $this->_categoryData[$cnt]['category_breadcrumbs_text'] = $attribute['Category breadcrumbs Text']; 
                     $this->_categoryData[$cnt]['category'] = $attribute['Category']; 
                     $this->_categoryData[$cnt]['origanl_bread'] = (isset($attribute['Origanl breadcrumbs']))?$attribute['Origanl breadcrumbs']:'';
                 }

                $cnt++;
            }

            $this->formatCategoryTree();
        }
    }

    public function getCategoryType($categoryUrl,$namePath,$breadcrumbs)
    {
        if(array_key_exists($namePath, $this->_optionBreadCrumbData))
        {
            return 'Item';
        }
        else if(array_key_exists($categoryUrl, $this->_optionData))
        {
            if(!array_key_exists($namePath, $this->_optionBreadCrumbData))
            {
                return 'Redirect';
            }
        }
        else if(array_key_exists($namePath, $this->_navigationBreadCrum))
        {
            return 'Group';
        }
        else if(array_key_exists($categoryUrl, $this->_navigationData))
        {
            if(!array_key_exists($namePath, $this->_navigationBreadCrum))
            {
                return 'Redirect';
            }
        }
        return NULL;
    }

    public function gethasItem($categoryUrl,$namePath)
    {	
    	
        if(array_key_exists($namePath, $this->_optionBreadCrumbData))
        {
            return 'Yes';
        }
        return 'No';
    }

     
    public function getRedirectToCategory($categoryUrl,$namePath)
    {
        if(count($this->_optionCategoryData))
        {
            foreach ($this->_optionCategoryData as $value) { 
               if($categoryUrl == $value['URL'] &&  $namePath != strtolower($value['Category breadcrumbs Text']))
               {
                    return $value['Category breadcrumbs Text'];
               }
            }
        }

        if(count($this->_navigationCategoryData))
        {
            foreach ($this->_navigationCategoryData as $value) { 
               if($categoryUrl == $value['URL'] &&  $namePath != strtolower($value['Category breadcrumbs Text']))
               {
                    return $value['Full Path'];
               }
            }
        }
        
        return '';
    }

    public function formatCategoryTree(){

        if(!$this->_categoryData)
        {
            return false;
        }
        
        $index=1;

        foreach ($this->_categoryData as $_data) {
            $itemCategoryCheck[strtolower($_data['full_path'])] =  $_data['category_url'];
            $groupCategoryCheck[strtolower($_data['category_breadcrumbs_text'])] =  $_data['url'];
        }

        foreach($this->_categoryData as $key =>$val)
        {
            if(!$val['full_path'])
            {
                continue;
            }

            $keyArrayTmp = explode("/", ltrim($val['full_path'],"/"));

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

                if(array_key_exists($treeKey, $this->_dataFinal))
                {
                    continue;
                }     
                 
                $namePath = strtolower(ltrim($treeKey, '/'));

                if(array_key_exists($namePath, $itemCategoryCheck))
                {
                    $categoryUrl = $itemCategoryCheck[$namePath];
                }
                else if(array_key_exists($namePath, $groupCategoryCheck))
                {
                     
                    $categoryUrl = $groupCategoryCheck[$namePath];
                }
                else
                {
                    $categoryUrl = "";
                }

                /*if(!empty($parentPath)){
                    
                    $categoryUrl = $val['category_url'];
                }
                else
                {
                    $categoryUrl = $val['url'];
                }*/

               
              
                $type = $this->getCategoryType($categoryUrl,$namePath,$val['category_breadcrumbs_text']);
                
            
                $hasItem = $this->gethasItem($categoryUrl,$namePath);
                $redirectTo = $this->getRedirectToCategory($categoryUrl,$namePath);

                $this->_dataFinal[$treeKey] = array(
                    "index"=>$index,
                    "name"=> $name,
                    "name_path"=> ltrim($treeKey, '/'),
                    "parentPath"=> $parentPath,
                    "full_path"=> $category,
                    "category_url"=> $categoryUrl,
                    "origanl_breadcrumbs"=> $val['origanl_bread'],
                    "type" => $type,
                    "has_item" => $hasItem,
                    "redirect_to_category" => $redirectTo,
                );
                
                $index++; 
            }
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
                        fputcsv($handler, $this->_headerReport, ",", "\"");
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