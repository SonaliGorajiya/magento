<?php
ini_set('memory_limit','512M');
class Ccc_practice_Adminhtml_CsvfileController extends Mage_Core_Controller_Front_Action
{
    protected $_categoryFile = 'C:\Users\User\Downloads\Csv _file\CATEGORY.csv';
    protected $_file = 'C:\Users\User\Downloads\Csv _file\ATTRIBUTE-OPTIONS.csv';
    protected $_fileReport = 'category-attribute-option.csv';

    public function indexAction()
    {
        try {
            $this->_loadFiles();
            $this->_formatData();
            $this->_generateReport();
            $this->_downloadReport();
            
            echo "DONE";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function _loadFiles()
    {
        $this->_loadCategoryFile();
        $this->_loadAttributeOptionFile();
    }

    protected function _loadCategoryFile()
    {
        $handler = fopen($this->_categoryFile, "r");
        
        if ($handler) {
            $this->_categoryData = array();
            $this->_categoryHeader = array();
            
            while ($row = fgetcsv($handler, 4096, ",", "\"")) {
                if (!$this->_categoryHeader) {
                    $this->_categoryHeader = $row;
                } else {
                    $row = array_combine($this->_categoryHeader, $row);
                    $this->_categoryData[$row["category"]][] = $row["attribute_code"];
                }
            }
            
            fclose($handler);
        } else {
            throw new Exception("Unable to open category file");
        }
    }

    protected function _loadAttributeOptionFile()
    {
        $handler = fopen($this->_file, "r");
        
        if ($handler) {
            $this->_data = array();
            $this->_header = array();
            
            while ($row = fgetcsv($handler, 4096, ",", "\"")) {
                if (!$this->_header) {
                    $this->_header = $row;
                } else {
                    $row = array_combine($this->_header, $row);
            echo "<pre>";print_r($row);die();
                    $this->_data[$row["attribute_code"]][] = $row["option"];
                }
            }
            
            fclose($handler);
        } else {
            throw new Exception("Unable to open attribute option file");
        }
    }

    protected function _formatData()
    {
        if (empty($this->_data)) {
            throw new Exception("Data is not available");
        }
        
        if (empty($this->_categoryData)) {
            throw new Exception("Category data is not available");
        }
        
        $this->_dataFinal = array();
        
        foreach ($this->_categoryData as $_category => $attribute) {
            foreach ($attribute as $att) {
                $tmp = array(
                    "category" => $_category, 
                    "attribute" => $att
                );
                
                if (!isset($this->_data[$att])) {
                    continue;
                }
                
                foreach ($this->_data[$att] as $option) {
                    $tmp["option"] = $option;
                    $this->_dataFinal[] = $tmp;
                }
            }
        }
    }

    protected function _generateReport()
    {   
        if (!empty($this->_dataFinal)) {
            $handler = fopen($this->_fileReport, "a"); 
            
            if ($handler) {   
                $cnt = 0;
                
                foreach ($this->_dataFinal as $key => $_data) {
                    if ($cnt == 0) {
                        fputcsv($handler, array_keys($_data), ",", "\"");
                        $cnt++;
                    }
                    
                    fputcsv($handler, $_data, ",", "\"");
                }
                
                fclose($handler);
            } else {
                throw new Exception("Unable to open file to write");
            }
        }
    } 

     protected function _downloadReport()
    {
        $fileContents = file_get_contents($this->_fileReport);

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=category-attribute-option.csv");

        echo $fileContents;
        exit;
    }


}


