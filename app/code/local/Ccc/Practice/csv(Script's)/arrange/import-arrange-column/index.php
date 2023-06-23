<?php
error_reporting(true);
ini_set("memory_limit","512M");

function trimStr($str)
{    
    $str = utf8_encode($str);
    $str = trim($str);
    return ucwords($str);
}

class Postal
{
    protected $_data = array();
    protected $_dataFinal = array();
    
    protected $_headerReport = array(
        "no"=>"",
        "file_name"=>"",
        "sheet_name"=>"",
        "store"=>"",
        "attribute_set"=>"",
        "websites"=>"",
        "type"=>"",
        "category_ids"=>"",
        "has_options"=>"",
        "upc"=>"",
        "mpn"=>"",
        "brand"=>"",
        "collection_type"=>"",
        "sku"=>"",
        "name"=>"",
        "url_key"=>"",
        "cost"=>"",
        "price"=>"",
        "msrp"=>"",
        "map_price"=>"",
        "selling_price"=>"",
        "special_price"=>"",
        "price_source"=>"",
        "reference"=>"",
        "call_price"=>"",
        "meta_title"=>"",
        "meta_description"=>"",
        "meta_keyword"=>"",
        "visibility"=>"",
        "status"=>"",
        "tax_class_id"=>"",
        "qty"=>"",
        "is_in_stock"=>"",
        "image"=>"",
        "sku_type"=>"",
        "weight_type"=>"",
        "price_type"=>"",
        "price_view"=>"",
        "short_description"=>"",
        "part_items"=>"",
        "is_part_item"=>"",
        "MFR Item Description"=>"MFR",
        "product_type"=>"MFR",
        "bed_size_measure"=>"MFR",
        "color"=>"MFR",
        "finish"=>"MFR",
        "bed_type"=>"MFR",
        "mattress_type"=>"MFR",
        "mattress_height"=>"MFR",
        "style"=>"MFR",
        "material"=>"MFR",
        "table_top_style"=>"MFR",
        "table_top_shape"=>"MFR",
        "seating_capacity"=>"MFR",
        "seat_height"=>"MFR",
        "seat_width"=>"MFR",
        "seat_depth"=>"MFR",
        "weight_capacity"=>"MFR",
        "distress_finish"=>"MFR",
        "upholstery_color"=>"MFR",
        "upholstery_material"=>"MFR",
        "comfort_level"=>"MFR",
        "assembly_required"=>"MFR",
        "television_fit_size"=>"MFR",
        "additional_features"=>"MFR",
        "variants"=>"MFR",
        "tailoring"=>"MFR",
        "country_of_manufacture"=>"MFR",
        "new"=>"MFR",
        "item_piece"=>"MFR",
        "box_spring_included"=>"MFR",
        "ships_within"=>"MFR",
        "shipping_method"=>"MFR",
        "shipment_type"=>"MFR",
        "length"=>"BOTH",
        "depth"=>"BOTH",
        "width"=>"BOTH",
        "height"=>"BOTH",
        "weight"=>"BOTH",
        "unit"=>"BOTH",
        "dimension"=>"BOTH",
        "cubic_feet"=>"BOTH",
        "dimentions_weight_desc"=>"BOTH",
        "description"=>"MFRDESCRIPTION",
        "key_features"=>"MFRDESCRIPTION"
    );
    
    
    protected $_headerReportTop = array();
    protected $_header = array();
    protected $_file = 'data.csv';
    protected $_fileReport = 'data-report.csv';
        
    protected function _loadFile()
    {
        $handler = fopen($this->_file, "r");

        if($handler)
        {
            while($row = fgetcsv($handler, 4096, ",", "\""))
            {
                if(!$this->_headerReportTop)
                {
                    $this->_headerReportTop = $row;
                }
                elseif(!$this->_header)
                {
                    $this->_header = $row;
                    $this->_headerReportTop = array_combine($this->_header, $this->_headerReportTop);
                    $this->_validateHeader();
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
    
    protected function _validateHeader()
    {   
        $missingHeader = array_diff(array_keys($this->_headerReport), $this->_header);
        
        if($missingHeader)
        {
            throw new Exception("Missing Header in file : ". implode(", ", $missingHeader));
        }
        
        $extraHeader = array_diff($this->_header, array_keys($this->_headerReport));
        
        if($extraHeader)
        {
            foreach($extraHeader as $column)
            {
                $this->_headerReport[$column] =  $this->_headerReportTop[$column];
            }
        }
    }
    
    public function run()
    {   
        try
        {
            echo "<pre>"; 
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
        # format header top
        
        if(!$this->_data)
        {
             throw new Exception("No data available to process");
        }
        
        foreach($this->_data as $data)
        {
            $row = array();
            
            foreach(array_keys($this->_headerReport) as $column)
            {
                 if(array_key_exists($column, $data))
                 {
                     $row[$column] =  $data[$column];
                 }
                 else
                 {
                     $row[$column] =  "";
                 }
            }
            
            $this->_dataFinal[] = $row;
        }
    }
    
    protected function _generateReport()
    {
        if($this->_dataFinal)
        {
            $handler = fopen($this->_fileReport, "a"); 
            
            if($handler)
            {   
                fputcsv($handler, array_values($this->_headerReport), ",", "\""); 
                fputcsv($handler, array_keys($this->_headerReport), ",", "\"");
                
                foreach($this->_dataFinal as $_data)
                {
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

$obj = new Postal();
$obj->run();

?>