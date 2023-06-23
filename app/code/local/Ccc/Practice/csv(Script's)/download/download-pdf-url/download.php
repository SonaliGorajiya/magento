<?php 

session_start();

error_reporting(1);
ini_set('max_execution_time', 10500);

class DownloadFile
{
    protected $_data = array();
    protected $_header = array();
    
    protected $_file = 'data.csv';
    protected $_destinationDir = 'pdf';
    
    
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
                    //$row["file_name"] = basename($row["url"]);
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
        }

        $this->_data = $_SESSION['data'];

        if(!$this->_data)
        {
            throw new Exception('Data is not available.');   
        }
        
        $report = array();
        
        if(array_key_exists($s, $this->_data))
        {    
            $destinationFile = $this->_destinationDir."/".$this->_data[$s]["file_name"];
            
            //$r = file_put_contents($destinationFile, file_get_contents($this->_data[$s]["url"]));

            /*$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->_data[$s]["url"]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSLVERSION,3);
            $data = curl_exec ($ch);
            $error = curl_error($ch); 
            curl_close ($ch);*/
            /*$options = array(
                CURLOPT_RETURNTRANSFER => true,     // return web page
               // CURLOPT_HEADER         => false,    // don't return headers
               // CURLOPT_FOLLOWLOCATION => true,     // follow redirects
               // CURLOPT_ENCODING       => "",       // handle all encodings
               // CURLOPT_USERAGENT      => "spider", // who am i
                //CURLOPT_AUTOREFERER    => true,     // set referer on redirect
                //CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
                //CURLOPT_TIMEOUT        => 120,      // timeout on response
                //CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
                CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
            );
            curl_setopt_array( $ch, $options );*/



           $ch = curl_init($this->_data[$s]["url"]);
           
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false );
            $content = curl_exec( $ch );
            curl_close( $ch );

            var_dump($content);die;

            file_put_contents($destinationFile, $content);

            $s = $s+1;

            header("Refresh:1; url=http://cccserver.in/team/harish/scripts/download/download-pdf-url/download.php?s=$s");
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