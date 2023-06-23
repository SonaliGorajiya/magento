<?php
class Data
{
    protected $_data = array();
    protected $_dataFinal = array();
    protected $_attributes = array();
    protected $_header = array();
    protected $_item = array();
    protected $_multiItem = null;
    protected $_price = array();
    protected $_itemPiece = null;
    protected $_multiPrice = null;
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
            throw new Exception("Data are not available");
        }

        if(count($this->_data))
        {
            $itemData = array();
            $series = null;

            foreach($this->_data as $_data)
            {      
                $_data['part_item'] = null;
                $_data['part_item_quantity'] = null;
                if($_data['configurations'] == 'set' )
                {
                    $this->_itemPiece = null;
                    $this->_multiItem = null;
                    $this->_multiPrice = null; 
                    $this->_price = array();
                    $this->_item = array();
                    continue;
                }

                if($_data['series_code'] != $series)
                {
                    $this->_itemPiece = null;
                    $this->_multiItem = null;
                    $this->_multiPrice = null; 
                    $this->_price = array();
                    $this->_item = array(); 
                }


                if($_data['configurations'] == 'configuration')
                {
                    if($_data['item_piece'])
                    {       
                        if(!empty($this->_multiItem))
                        {
                           $singleCount  = count($this->_item) - 1;
                           $addItemCount = $_data['item_piece'] - $singleCount;

                           if($this->_itemPiece == 0)
                           {
                                continue;
                           } 

                           $addItem = ($addItemCount / $this->_itemPiece);
                            
                           $this->_item = array_diff($this->_item, array($this->_multiItem));

                           for ($i=1; $i <=  $addItem ; $i++) 
                           { 
                                $this->_item[] = $this->_multiItem;
                                $this->_price[] = $this->_multiPrice;
                           }

                           $_data['item_piece'] = $singleCount + $addItem;
                            
                           $_data['part_item_quantity'] = $this->_multiItem."(".$addItem.")";
                        }

                        $count = $_data['item_piece'];

                        $itemData = array_slice(array_reverse($this->_item), 0,$count);
                        $itemTotalPrice = array_slice(array_reverse($this->_price), 0,$count);

                        if($_data['Price'] == array_sum($itemTotalPrice)) 
                        {
                            $_data['part_item'] = implode(';', array_reverse($itemData));
                        }
                    }

                    $this->_itemPiece = null;
                    $this->_multiItem = null;
                    $this->_multiPrice = null;
                    $this->_price = array();
                    $this->_item = array();
                }
                else
                {
                    if($_data['item_piece'] < 1)
                    {
                        $this->_itemPiece = $_data['item_piece'];
                        $this->_multiItem = $_data['SKU'];
                        $this->_multiPrice = $_data['Price'];
                    }

                    $this->_item[] = $_data['SKU'];
                    $this->_price[] = $_data['Price'];
                }
                $series = $_data['series_code'];
                $this->_dataFinal[] = $_data;
            }
        }
    }

    
    public function getHeaderTitle()
    {
         $this->_header[] = 'part_item';
         $this->_header[] = 'part_item_quantity';
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