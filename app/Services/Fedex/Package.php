<?php
/**
 * Mubashir Ali
 * saad_ali6@yahoo.com
 */
namespace App\Services\Fedex;
    class Package
    {
        var $Weight = array();
        var $Dimensions = array();
        var $ItemDescription;
        public function __construct($package_desc, $seq = "", $group_pack_count = "") 
        {
            $this->ItemDescription = $package_desc;
            
            if(trim($seq) != "")
                $this->SequenceNumber = $seq;

            if(trim($group_pack_count) != "")
                $this->GroupPackageCount = $group_pack_count;
        }
        
        public function setPackageWeight($value, $unit = "LB")
        {
            if(!in_array(strtoupper($unit), array('KG', 'LB')))
                return array("Error", "Package Unit should be LB or KG");
            
            $this->Weight['Value'] = round($value,2);
            $this->Weight['Units'] = strtoupper($unit);
        }
        
        public function setPackageDimensions($length, $width, $height, $unit = "IN")
        {            
            if(!in_array(strtoupper($unit), array('FT', 'IN')))
                return array("Error", "Package Unit should be IN or FT");
            
            $this->Dimensions['Length'] = $length;
            $this->Dimensions['Width'] = $width;
            $this->Dimensions['Height'] = $height;
            $this->Dimensions['Units'] = $unit;
        }
        
        public function getObjectArray()
        {
            return (array)$this;
        }
    }
    
?>