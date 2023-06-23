<?php 
session_start();

error_reporting(1);
ini_set('max_execution_time', 10500);

class DownloadFile
{
    protected $_data = array();
    protected $_header = array();
    
    protected $_file = 'data.csv';
    protected $_destinationDir = 'data';
    
    
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

                    
                    if(!trim($row["file_name"]))
                    {
                        $row["file_name"] = basename($row["url"]);
                    }
                    else
                    {
                        $row["file_name"] = urldecode($row["file_name"]); 
                    }

                    $this->_data[] =  $row;
                }
            }    
            fclose($handler);
        }
        else
        {
            throw new Exception("Unable to open file");     
        }

        if($this->_data)
        {
            $_SESSION['data'] = $this->_data;    
        }
    }
    
    public function run()
    {
        echo '<pre>';

        if(!isset($_SESSION['data']))
        {
            $this->_loadFile();    
        }
        
        $this->_downloadFile();
        
    }
    
    protected function _downloadFile()
    {
        $s = (isset($_GET["s"])) ? $_GET["s"]  : 0;

        if($s==-1)
        {
            unset($_SESSION['data']);
            echo "Session is cleared. please run download.php without any parameter for start downloading process.";
            exit;
        }

        $this->_data = $_SESSION['data'];

        if(!$this->_data)
        {
            throw new Exception('Data is not available in file or pending to read. Please run download.php without any parameter for start downloading process.');
        }
        
        $report = array();
        
        if(array_key_exists($s, $this->_data))
        {    
            $destinationFile = $this->_destinationDir."/".$this->_data[$s]["file_name"];
           

            //echo $this->_data[$s]["url"];die;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, "{$_SERVER['SERVER_NAME']}");
            curl_setopt($ch, CURLOPT_URL, $this->_data[$s]["url"]);

            $content = curl_exec($ch);

            echo "<pre>";
            var_dump($content);
            die;

            curl_close( $ch );

            file_put_contents($destinationFile, $content);

            $s = $s+1;

            header("Refresh:1; url=http://cccserver.in/team/harish/scripts/download/download-html-page/download.php?s=$s");
        }
        else
        {
            unset($_SESSION['data']);
            echo "Downloaded Ended.";
        }
    }
}


$object = new DownloadFile();
$object->run();


?>