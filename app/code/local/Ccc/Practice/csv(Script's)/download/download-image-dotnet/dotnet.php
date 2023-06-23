<?php 
error_reporting(1);
ini_set('max_execution_time', 10500);

class Dot_Net
{
    protected $_notifyURL = 'http://www.1stopbedrooms.com/imgimport/download.php';
	
	protected function _notifyDownloadServer()
	{
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
            throw new Exception("Notified to download server : No Response");
		}
        
        throw new Exception("Notified to download server");
        
		return $this;
	}
    
    
	
	public function process()
	{
		try
		{   
			$this->_notifyDownloadServer();
            
			die;
				
		}
		catch(Exception $e)
		{	
			echo $e->getMessage(); 
		}
	}
}

$object = new Dot_Net();
$object->process();

?>