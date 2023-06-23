<?php

class Ccc_Practice_Adminhtml_CsvController extends Mage_Adminhtml_Controller_Action
{

    protected $_data = array();
    protected $_header = array();
    
    protected $_categoryData = array();
    protected $_categoryHeader = array();
    
    protected $_dataFinal = array();
    
    protected $_categoryFile = 'C:\Users\User\Downloads\Csv _file\CATEGORY.csv';
    protected $_file = 'C:\Users\User\Downloads\Csv _file\ATTRIBUTE-OPTIONS.csv';
    protected $_fileReport = 'C:\Users\User\Downloads\Csv _file\category-attribute-option.csv';

    public function indexAction()
    {   
        echo "<pre>";
        $csv = new Varien_File_Csv();

        $this->_prepareData();
        $this->_formatData();
        $csv->saveData($this->_fileReport, $this->_dataFinal);

        echo "DONE";
        die;
    }
        
    protected function _prepareData()
    {
        $csv = new Varien_File_Csv();

        $data = $csv->getData($this->_file);
        $categoryData = $csv->getData($this->_categoryFile);

         if(!$data)
        {
            throw new Exception("Data is not available in file");
        }
        
        if(!$categoryData)
        {
            throw new Exception("Category data is not available in file");
        }

        foreach ($categoryData as $row)
        {
            if(!$this->_categoryHeader)
            {
                $this->_categoryHeader = $row;
            }
            else
            {
                $row = array_combine($this->_categoryHeader, $row);
                $this->_categoryData[] = $row;
            }
        }    

        foreach ($data as $row) 
        {
            if(!$this->_header)
            {
                $this->_header = $row;
            }
            else
            {
                $row = array_combine($this->_header, $row);
                $option = $row['OPTION'];
                $this->_data[$option] = $row;
            }
        }  
    }
    
    protected function _formatData()
    {
        if(!$this->_data)
        {
            throw new Exception("Data is not available");
        }
        
        if(!$this->_categoryData)
        {
            throw new Exception("Category data is not available");
        }
        $this->_dataFinal[] = array('index','category','attribute' ,'option');
        $categoryData = array_unique(array_column($this->_categoryData,'CATEGORY'));
        $index = 1;
        foreach($categoryData as $_category)
        {
            foreach($this->_data as $opt =>$data)
            {
                $output = array(
                    'index' => $index,
                    'category' => $_category,
                    'attribute' => $data['ATTRIBUTE'],
                    'option' => $data['OPTION'],
                );
                $this->_dataFinal[] = $output; 
                $index ++;
            }
        }
    }
    
    public function getData()
    {
        return $this->_data;
    }

    public function getCategoryData()
    {
        return $this->_categoryData;
    }

    public function getDataFinal()
    {
        return $this->_dataFinal;
    }


    public function twoAction()
    {
        $csvMergeObj = Mage::getModel('practice/csvmerge');
        
        $csvMergeObj->setCategoryFile('C:\Users\User\Downloads\CATEGORY.csv');
        $csvMergeObj->setOptionFile('C:\Users\User\Downloads\ATTRIBUTE-OPTIONS.csv');
        $csvMergeObj->setFinalFile('C:\Users\User\Downloads\category-attribute-option.csv');

        $file = $csvMergeObj->run();
        
        $this->_prepareDownloadResponse('category-attribute-option.csv', file_get_contents($file));
    }
}