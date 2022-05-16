<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Traits\WithDBoid;

class TSAcronym extends TSModel
{

    // use WithDBoid;
    
    protected static $root_node="acronym";

    public $acronymcod;
    public $acronymnam;
    // public $interactiverec;
    

    protected $property_mutators= [
        "acronymcod" => "code",
        "acronymnam" => "name",
    ];
    
    
}
