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
            while($row = fgetcsv($handler, 4096, ",", "\""))
            {
                if(!$this->_header)
                {
                    $this->_header = $row;
                }
                else
                {
                    $row = array_combine($this->_header, $row);
                    $this->_data[$row["brand"]][$row["sku"]] = $row;
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

        //echo "<pre>";print_r($this->_data);exit;
        $i = 1;
        foreach ($this->_data as $brand => $row) 
        {
            foreach ($row as $sku => $value) 
            {
                //echo $sku."<br>";

                $systemSkus = $this->_getPercentageBasedOnSemicolonOrDash($sku);
                foreach ($systemSkus as $_sku) 
                {
                    $this->_dataFinal[] = array(
                        "INDEX" => $i++,
                        "brand" => $brand,
                        "type" => $value['type'],
                        "main_sku" => $sku,
                        "match_sku" => $_sku
                        );
                }
            }
            //exit;
        }
    }

    protected function _getPercentageBasedOnSemicolonOrDash($sku)
    {
        if((strpos($sku, ";") !== false))
        {
            $systemSkus = $this->_prepareSkuBasedOnSemiColon($sku);
        }
        elseif((strpos($sku, "-") !== false))
        {
            $systemSkus = $this->_prepareSkusBasedOnDash($sku);
        }
        else
        {
            $systemSkus = array(trim(preg_replace('/[^A-Za-z0-9]/', '', $sku)));
        }
        //$systemSku = array(trim($sku));
        //$systemSkus = array_merge($systemSku,$systemSkus);
        $systemSkus = array_unique(array_filter($systemSkus));
    
        return $systemSkus;
    }

    protected function _prepareSkuBasedOnSemiColon($skuParam)
    {
        $formattedValidSkus = array();

        $skus = explode(";", $skuParam);
        foreach ($skus as $_sku)
        {
            if((strpos($_sku, "-") !== false))
            {
                $formattedValidSku = $this->_prepareSkusBasedOnDash($_sku);
                $formattedValidSkus = array_merge($formattedValidSkus,$formattedValidSku);
            }
            else
            {
                $formattedValidSkus[] = $_sku;
            }
        }
       
        if(count($formattedValidSkus))
        {        
            $formattedValidSkus = array_map(function($sku){
                return trim(preg_replace('/[^A-Za-z0-9-]/', '', $sku));
            }, $formattedValidSkus);
        }

        return $formattedValidSkus;
    }

    protected function _prepareSkusBasedOnDash($skuParam)
    {
        $formattedValidSkus = array();

        $skus = explode("-", $skuParam);
        //print_r($skus);exit;
        if(count($skus))
        {
            foreach($skus as $key => $sku)
            {
                if($key == 0)
                {
                    $formattedValidSkus[] = $sku;
                    continue;
                }

                if(strlen($sku) <= 4 && strlen($skus[0]) > strlen($sku))
                {
                    $formattedValidSkus[] = substr($skus[0], 0, -strlen($sku)) .$sku;   
                }

                if(strlen($sku) > 4)
                {
                    $formattedValidSkus[] = $sku;
                }

                $formattedValidSkus[] = $skus[0].$sku;
            }
        }

        if(count($skus) > 2)
        {
            foreach($skus as $key => $sku)
            {
                if($key == 0)
                {
                    continue;
                }

                $formattedValidSkus[] = $skus[0]."-".$sku;
            }
        }
        elseif(isset($skus[0]) && isset($skus[1]))
        {
            $formattedValidSkus[] = $skus[0]."-".$skus[1];
        }
        else
        {
            $formattedValidSkus[] = $skus[0];
        }
        
        if(count($formattedValidSkus))
        {        
            $formattedValidSkus = array_map(function($sku){
                return trim(preg_replace('/[^A-Za-z0-9-]/', '', $sku));
            }, $formattedValidSkus);
        }
        return $formattedValidSkus;
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