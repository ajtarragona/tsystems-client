<?php 

namespace Ajtarragona\Tsystems\Models;

class TSRequest{
    protected $xml_tag="taoServiceRequest";
    
    public $application;
    public $businessName;
    public $operationName;
    public $data;
    
}