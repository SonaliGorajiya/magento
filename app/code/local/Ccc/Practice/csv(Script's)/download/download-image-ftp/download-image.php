<?php 
error_reporting(1);
ini_set('max_execution_time', 10500);

class DownloadFile
{
	protected $_host = '66.129.85.141';
    protected $_port = 21;
    protected $_timeout = 90;
    
    protected $_userName = 'zuo_public_7520';
    protected $_password = 'zuomod.com';
    
    protected $_connect = NULL;
    protected $_login = NULL;
    
    
    protected $_connectionFailureCount = 0;
                                           
    protected $_currentFile = array();
    
    protected $_data = array(
        array(
            "path" => "2016_products/modern/lifestyle/medium",
            "image" => "900666_lifestyle.jpg",
        ),
        array(
            "path" => "2016_products/modern/lifestyle/medium",
            "image" => "900649_900651_lifestyle.jpg",
        ),
        array(
            "path" => "2016_products/modern/lifestyle/medium",
            "image" => "900641_900645_lifestyle.jpg",
        )
    );
    
    
    
    //added dynamic
    protected $_currentLocalFileName = NULL;
    protected $_localFileHandler = NULL;
    	
	protected $_downloadFailCount = 0;
	
	
	protected $_reportFileName = 'report.csv';
	protected $_reportFileNameHandler = NULL;
    
    const STATUS_FAILURE = "FAILURE";
    const STATUS_SUCCESS = "SUCCESS";
    
    
    protected $_file = 'data.csv';
    
    
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
                    $this->_data[] =  $row;
                }
            }    
            fclose($handler);
        }
        else
        {
            throw new Exception("Unable to open file");     
        }
    }
	
	protected function _openReportFile()
	{
		$this->_reportFileNameHandler = fopen($this->_reportFileName, 'a');
		
		if(!is_resource($this->_reportFileNameHandler))
		{
			throw new Exception('Unable to open report file in append mode');
		}	
		
		return $this;
	}
	
	protected function _writeInReportFile($message, $status)
	{	
		if(!is_resource($this->_reportFileNameHandler))
		{
			$this->_openReportFile();
		}	
        
        $data = array($message, date("Y-m-d H:i:s"), $status);
		fputcsv($this->_reportFileNameHandler, $data);
		
		return $this;
	}
	
	protected function _closeReportFile()
	{
		if(is_resource($this->_reportFileNameHandler))
		{
			if(!fclose($this->_reportFileNameHandler))
			{
				throw new Exception('Unable to close report File.');
			}
		}
		
		return $this;
	}
	
			
	protected function _connectToFTP()
	{
		try
		{
		
			$this->_connect = ftp_connect ($this->_host, $this->_port, $this->_timeout);
			
			if(!is_resource($this->_connect))
			{
				throw new Exception('Unable to connect to FTP server.');
			}
            
            $this->_writeInReportFile("Connected to FTP server", self::STATUS_SUCCESS);
		}
		catch(Exception $e)
		{
			if($this->_connectionFailureCount > 3)
			{
				throw new Exception('Tried to connect server 3 times but still not able to connect. System will try again after 5 Minutes.');
			}
			
			$this->_writeInReportFile($e->getMessage(), self::STATUS_FAILURE);
			
			$this->_connectionFailureCount++;
			$this->_connectToFTP();
		}
		
		
		return $this;
	}
	
	protected function _closeFTPConnection()
	{
		if(is_resource($this->_connect))
		{
			if(!ftp_close($this->_connect))
			{
				throw new Exception('Unable to close FTP connection.');
			}
            
            $this->_writeInReportFile("FTP connection closed", self::STATUS_SUCCESS);
		}
		
		return $this;
	}
	
	
	protected function _loginToFTP()
	{
		$this->_login = ftp_login ($this->_connect, $this->_userName, $this->_password);
		
		if(!$this->_login)
		{
			throw new Exception('Unable to login to FTP server.');
		}
       
        $this->_writeInReportFile("Logged In to FTP server", self::STATUS_SUCCESS);
		
		return $this;
	}
    
    protected function _logoutFromFTP()
    {
        if($this->_login)
        {
            $this->_login = NULL;
            
            $this->_writeInReportFile("Logged out from FTP server", self::STATUS_SUCCESS);    
        }
        
        return $this;
    }
	
	
	protected function _openLocalFile()
	{
        $this->_currentLocalFileName = 'brand_images/zuo_modern'.DIRECTORY_SEPARATOR.$this->_currentFile["image"];
		$this->_localFileHandler = fopen($this->_currentLocalFileName, 'w+');
		
		if(!is_resource($this->_localFileHandler))
		{
			throw new Exception('Unable to open file in W+ mode');
		}	
		
		return $this;
	}
	
	protected function _closeLocalFile()
	{
		if(is_resource($this->_localFileHandler))
		{
			if(!fclose($this->_localFileHandler))
			{
				throw new Exception('Unable to close local downloaded File.');
			}
		}
		
		return $this;
	}
    
    protected function _liveFilePath()
    {
        return $this->_currentFile["path"].DIRECTORY_SEPARATOR.$this->_currentFile["image"];
    }
	
	protected function _downloadFile()
	{
		if(!is_resource($this->_connect))
		{
			$this->_connectToFTP();
		}
		
		$this->_openLocalFile();
        ftp_pasv($this->_connect, TRUE);
		$fileResource = ftp_fget( $this->_connect, $this->_localFileHandler , $this->_liveFilePath() , FTP_BINARY, 0);
		
        if($this->_downloadFailCount > 2)
        {
            //throw new Exception('Tried to download file 3 times but still not able to download');
        }
        
        if(!$fileResource)
		{
            $this->_downloadFailCount++;
            $this->_writeInReportFile("Unable to download file", self::STATUS_FAILURE);
			
			//$this->_downloadFile();
		}
        
        unset($fileResource);                                                      
        $this->_downloadFailCount = 0;
		
        $this->_closeLocalFile();
		return $this;
	}
	
	
	public function process()
	{
		try
		{   
            $this->_loadFile();
            
			$this->_openReportFile();
            
            
            $this->_connectToFTP();	
			$this->_loginToFTP();
			
            $s = (isset($_GET["s"])) ? $_GET["s"]  : 0;            
            
            if(array_key_exists($s, $this->_data))
            {
                $this->_currentFile = $this->_data[$s];
                $this->_downloadFile();
                
                $s = $s+1;
                
                header("Refresh:1; url=http://furnique.nextmp.net/download-image.php?s=$s");
            }
            
            $this->_logoutFromFTP();
			$this->_closeFTPConnection();
			$this->_closeReportFile();
            
            
			
			die;
				
		}
		catch(Exception $e)
		{	
            $this->_logoutFromFTP();
            $this->_closeFTPConnection();
			$this->_closeReportFile();
			
            header("Refresh:1; url=http://furnique.nextmp.net/download-image.php?s=$s");
            
		}
	}
}

$object = new DownloadFile();
$object->process();


?>