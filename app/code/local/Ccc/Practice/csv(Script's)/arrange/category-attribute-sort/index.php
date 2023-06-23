<?php

class Data
{
    protected $_data = array();
    protected $_dataFinal = array();
    protected $_attributes = array();
    
    protected $_attributeIndex = array(
        "product_type",
        "color",
        "finish",
        "distress_finish",
        "material_type",
        "design",
        "style",
        "theme",
        "print",
        "pattern",
        "life_stage",
        "age_group",
        "shape",
        "top_material",
        "top_finish",
        "base_finish",
        "base_material",
        "base_design",
        "base_style",
        "cushion_color",
        "seating_type",
        "seat_style",
        "seat_material",
        "seat_finish",
        "seat_color",
        "arms",
        "arm_type",
        "arm_material",
        "back",
        "back_style",
        "wood_type",
        "wood_tone",
        "wood_finish",
        "upholstery_material",
        "upholstery_color",
        "cover",
        "cover_material",
        "mattress_top",
        "mattress_position",
        "mattress_height",
        "mattress_size",
        "number_of_shelves",
        "number_of_drawers",
        "number_of_doors",
        "number_of_cabinets",
        "number_of_tiers",
        "number_of_taps",
        "number_of_hooks",
        "number_of_seats",
        "number_of_steps",
        "frame_material",
        "frame_finish",
        "frame_color",
        "frame_features",
        "woven_material",
        "shelf_material",
        "counter_material",
        "weight_capacity",
        "seating_capacity",
        "capacity",
        "solid_wood",
        "storage_type",
        "installation_type",
        "panels",
        "bed_size_measure",
        "bunk_configuration",
        "orientation",
        "personalization",
        "service_size",
        "keg_size",
        "compatibility",
        "av_features",
        "bins_included",
        "skirt_style",
        "television_fit_size",
        "row_style",
        "slats_required",
        "slats_included",
        "box_spring_required",
        "box_spring_included",
        "comfort_level",
        "fill",
        "pillow_size",
        "temperature_zone",
        "space_heating_capacity",
        "maximum_heating_output",
        "heat_source",
        "fuel_type",
        "vent",
        "stemware_capacity",
        "clock_type",
        "bottle_capacity",
        "item_piece",
        "ship_method",
        "compliance_certifications",
        "assembly_required",
        "assembly",
        "key_features",
        "application",
        "recommended_for_commercial_use",
        "warranty_terms",
        "product_care",
        "customer_sales_rating",
        "gender",
        "dimension",
        "length",
        "depth",
        "width",
        "height",
        "weight",
        "cubic_feet",
        "seat_height",
        "seat_width",
        "thread_count",
        "ladder_height"
    );
   
    protected $_header = array();
    protected $_file = 'data.csv';
    protected $_fileReport = 'data-report.csv';
        
    protected function _loadFile()
    {
        /*echo "<pre>";
        
        print_r($this->_attributeIndex);die;*/
        
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
                    
                    if(!array_key_exists($row["category"], $this->_data))
                    {
                        $this->_data[$row["category"]] = array();
                    }
                    
                    $this->_data[$row["category"]][] = $row;
                    
                    $this->_attributes[$row["attribute_code"]] = $row["attribute_code"];
                    
                }
            }    
            fclose($handler);
        }
        else
        {
            throw new Exception("Unable to open file");     
        }
        echo "<pre>";
        print_r($this->_data);
        print_r($this->_attributes);die;
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
            throw new Exception("Postals are not available");
        }
        
        $missingAttributes = array_diff($this->_attributes, $this->_attributeIndex);
        
        if($missingAttributes)
        {
            echo "Extra attribute in file : ".implode(", ", $missingAttributes)."<br><br>";
        }
        
        $this->_attributeIndex = array_flip($this->_attributeIndex);
        
        foreach($this->_data as $category => $attributes)
        {
            if($attributes)
            {
                $cnt = 1;
                foreach($attributes as $row)
                {
                    if(array_key_exists($row["attribute_code"], $this->_attributeIndex))
                    {
                        $row["sort_order"] =  $this->_attributeIndex[$row["attribute_code"]] + 1;
                        $this->_dataFinal[] = $row;
                    }
                }
            }
            
        }
    }
    
    protected function _generateReport()
    {   
        if($this->_dataFinal)
        {
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