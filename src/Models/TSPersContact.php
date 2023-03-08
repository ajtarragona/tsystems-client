<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Traits\WithDBoid;

class TSPersContact extends TSModel
{
    use WithDBoid;
    
    const TIPUS_EMAIL = [21,22];
    const TIPUS_PHONE = [1,2,3,4];
    
    protected static $root_node="perscontact";
    
    public $waycode;
    public $wayvalue;
    public $isdefault;
    
    protected $property_mutators= [
        "waycode" => "code",
        "wayvalue" => "value",
    ];

}
