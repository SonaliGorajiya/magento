<?php
class Data
{
    protected $_data = array();
    protected $_dataFinal = array();
    protected $_header = array();
    protected $_file = 'data-bfd.csv';
    protected $_fileReport = 'bfdurls.csv';
        
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
            $index = 1;
            foreach($this->_data as $_data)
            {      
                $_data['record'] = (int)$_data['record'];
                $_data['per_page'] = (int)$_data['per_page'];

                if($_data['record'] > $_data['per_page'])
                {
                    $total_page = $_data['record'] / $_data['per_page'] ;

                    if($total_page > floor($total_page))
                    {
                        $total_page = floor($total_page) + 1;
                    }
                }
                else
                {
                    $total_page = 1;
                }

                for($count = 1; $count <= $total_page; $count++)
                {
                    $row = $_data;
                    $row['url'] = $_data['url'].'?limit='.$_data['per_page'].'&p='.$count;
                    $row['total_page'] = $total_page;
                    $row['index'] = $index;
                    
                    $this->_dataFinal[] = $row;
                    $index++;
                }
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
                        $this->_header = array_keys($_data);
                        fputcsv($handler, $this->_header, ",", "\"");
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