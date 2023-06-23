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
                    $this->_data[] = $row;
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
        
       	foreach ($this->_data as $key => $row) 
       	{
       		$this->	callCurl($row);
       	}
    }

    public function callCurl($row)
    {
    	$callUrl = 'https://www.googleapis.com/customsearch/v1?key='.$this->_key.'&cx='.$this->_engineId.'&q=https://www.bedroomfurniturediscounts.com/media/catalog/product/9/5/95973.jpg&searchType=image&image_filter=0';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, "{$_SERVER['SERVER_NAME']}");
		curl_setopt($ch, CURLOPT_URL, $callUrl);
		$content = curl_exec($ch);
		curl_close( $ch );

		$row['title'] = NULL;
		$row['htmlTitle'] = NULL;
		$row['link'] = NULL;
		$row['displayLink'] = NULL;
		$row['snippet'] = NULL;
		$row['htmlSnippet'] = NULL;
		$row['mime'] = NULL;
		$row['contextLink'] = NULL;
		$row['height'] = NULL;
		$row['width'] = NULL;
		$row['thumbnailLink'] = NULL;
		$row['thumbnailHeight'] = NULL;
		$row['thumbnailWidth'] = NULL;
		$row['status'] = NULL;

		$response = array();
		if($contentData = json_decode($content))
		{
			if(!property_exists($contentData, "items"))
			{
				$response = $row;
				$response['status'] = 'items MISSING';

				$this->_dataFinal[] = $response;
				return $this;
			}

			foreach ($contentData->items as $key => $item) 
			{
				$response = $row;

				$response['status'] = 'OK';

				$response['title'] = $item->title;
				$response['htmlTitle'] = $item->htmlTitle;
				$response['link'] = $item->link;
				$response['displayLink'] = $item->displayLink;
				$response['snippet'] = $item->snippet;
				$response['htmlSnippet'] = $item->htmlSnippet;
				$response['mime'] = $item->mime;

				if(!property_exists($item, "image"))
				{
					$response['status'] = 'image MISSING';
				}
				else
				{
					$response['contextLink'] = $item->image->contextLink;
					$response['height'] = $item->image->height;
					$response['width'] = $item->image->width;
					$response['thumbnailLink'] = $item->image->thumbnailLink;
					$response['thumbnailHeight'] = $item->image->thumbnailHeight;
					$response['thumbnailWidth'] = $item->image->thumbnailWidth;
				}

				$this->_dataFinal[] = $response;
			}
		}
		else
		{
			$response = $row;
			$response['status'] = 'JOSN ISSUE';

			$this->_dataFinal[] = $response;
		}

		return $this;
    }
    
    protected function _generateReport()
    {   
        if($this->_dataFinal)
        {

        	if(file_exists($this->_fileReport))
        	{
        		unlink($this->_fileReport);
        	}

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