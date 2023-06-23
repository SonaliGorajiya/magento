<?php 
error_reporting(1);
ini_set('max_execution_time', 10500);

class CURL
{
    protected function _notifyDownloadServer()
    {    
       $data = array(
"curl --header 'Host: dl.dropboxusercontent.com' --header 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0' --header 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' --header 'Accept-Language: en-US,en;q=0.5' --header 'Connection: keep-alive' 'https://dl.dropboxusercontent.com/content_link_zip/uxyIImmm1ROfiLJ7AKgjLQfH0J9RJYDEBUz6yrDOxsXrrWmksmjC5dF3GhcOb8u4/file' -o '245 B.zip' -L",
"curl --header 'Host: dl.dropboxusercontent.com' --header 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0' --header 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' --header 'Accept-Language: en-US,en;q=0.5' --header 'Cookie: uc_session=8MoQmED6ubjaXQTRgINtaz5lz9QYmYiCtj2yMu0witY0lRizLzVZZQDunPlIpKlz' --header 'Connection: keep-alive' 'https://dl.dropboxusercontent.com/content_link_zip/h58vrLDUzGhFYKmPRbqYDvmPPOmCdNe4wNvotGa77ByVEsEJjsurDYs57TGqmgGp/file' -o '245 D.zip' -L",
"curl --header 'Host: dl.dropboxusercontent.com' --header 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0' --header 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' --header 'Accept-Language: en-US,en;q=0.5' --header 'Cookie: uc_session=8MoQmED6ubjaXQTRgINtaz5lz9QYmYiCtj2yMu0witY0lRizLzVZZQDunPlIpKlz' --header 'Connection: keep-alive' 'https://dl.dropboxusercontent.com/content_link_zip/jLYFZ13ITMUrMcLWtzllTK5hRc2amqo7LKRf8QaYtwBOuoYwqkiGEsUyGB2c9fLc/file' -o '245 L.zip' -L",
"curl --header 'Host: dl.dropboxusercontent.com' --header 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0' --header 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' --header 'Accept-Language: en-US,en;q=0.5' --header 'Cookie: uc_session=8MoQmED6ubjaXQTRgINtaz5lz9QYmYiCtj2yMu0witY0lRizLzVZZQDunPlIpKlz' --header 'Connection: keep-alive' 'https://dl.dropboxusercontent.com/content_link_zip/TCM3ZgC7SWgefeTsnyjQCHxEHycuHsiqR1dxHqyjOxdXNY7jg5mLF49dW53gju2g/file' -o 'Catalog PDF.zip' -L"

);
        
        foreach($data as $t)
        {
            exec($t);
        }
                                                                                                                                      
        
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

$object = new CURL();
$object->process();

?>