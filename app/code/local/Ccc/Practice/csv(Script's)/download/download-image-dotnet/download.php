<?php 
error_reporting(1);
ini_set('max_execution_time', 10500);

class DownloadFile
{
	protected $_host = 'FTP.SMARTERASP.NET';
    protected $_port = 21;
    protected $_timeout = 90;
    
    protected $_userName = 'christopherpatel-001';
    protected $_password = 'ccc123456';
    
    protected $_connect = NULL;
    protected $_login = NULL;
    
    
    protected $_connectionFailureCount = 0;
    
    protected $_downloadFileName = 'image.zip';
    
    //added dynamic
    protected $_currentLocalFileName = NULL;
    protected $_localFileHandler = NULL;
    protected $_liveFilePath = 'site1/Data/ZipImage/image.zip';
    
    protected $_notifyURL = 'http://queen123-001-site1.ctempurl.com/DownLoadImage.aspx?download=1';
		
	protected $_downloadFailCount = 0;
	
	
	protected $_reportFileName = 'report.csv';
	protected $_reportFileNameHandler = NULL;
    
    const STATUS_FAILURE = "FAILURE";
    const STATUS_SUCCESS = "SUCCESS";
	
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
		$this->_currentLocalFileName = 'zip'.DIRECTORY_SEPARATOR.basename($this->_downloadFileName).'_'.date('Y-m-d-H-i-s').'.zip';
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
	
	protected function _downloadFile()
	{
		if(!is_resource($this->_connect))
		{
			$this->_connectToFTP();
		}
		
		$this->_openLocalFile();
        ftp_pasv($this->_connect, TRUE);
		$fileResource = ftp_fget( $this->_connect, $this->_localFileHandler , $this->_liveFilePath , FTP_BINARY, 0);
		
        if($this->_downloadFailCount > 2)
        {
            throw new Exception('Tried to download file 3 times but still not able to download');
        }
        
        if(!$fileResource)
		{
            $this->_downloadFailCount++;
            $this->_writeInReportFile("Unable to download file", self::STATUS_FAILURE);
			
			$this->_downloadFile();
		}
        
        unset($fileResource);                                                      
        $this->_writeInReportFile("Downloaded file : ".$this->_currentLocalFileName, self::STATUS_SUCCESS);
		
        $this->_closeLocalFile();
		return $this;
		
	}
	
	protected function _notifyDownloadServer()
	{
        sleep(2);
		$request["process"] = 1;
		
		$_curl = curl_init($this->_notifyURL);
		curl_setopt($_curl, CURLOPT_HTTPHEADER, array('Content-Type: text/html'));
		curl_setopt($_curl, CURLOPT_POST, true);
		curl_setopt($_curl, CURLOPT_POSTFIELDS, $request["process"]);
		curl_setopt($_curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($_curl, CURLOPT_TIMEOUT, 600);
		$response = curl_exec($_curl); 
		
		if(!$response)
		{
			throw new Exception("Notified server : No Response");
		}
        
        $this->_writeInReportFile("Notified to .NET server about file downloaded", self::STATUS_SUCCESS);     
        
		return $this;
		
		//
	}
    
    protected function _receivedDownloadRequest()
    {
        $this->_writeInReportFile("Init: Received Request from .NET server to download zip file", self::STATUS_SUCCESS);
    }
	
	public function process()
	{
		try
		{
			$this->_openReportFile();
            
            $this->_receivedDownloadRequest();
            $this->_connectToFTP();	
			$this->_loginToFTP();
			$this->_downloadFile();	
            $this->_logoutFromFTP();
			$this->_closeFTPConnection();
			$this->_notifyDownloadServer();
            
            $this->_closeReportFile();
			
			die;
				
		}
		catch(Exception $e)
		{	                                          
            $this->_writeInReportFile($e->getMessage(), self::STATUS_FAILURE); 
            
            $this->_logoutFromFTP();
            $this->_closeFTPConnection();
			$this->_closeReportFile();
			echo $e->getMessage(); 
		}
	}
}

$object = new DownloadFile();
$object->process();


?>