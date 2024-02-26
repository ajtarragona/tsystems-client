<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Traits\WithDBoid;

class TSPersContact extends TSModel
{
    use WithDBoid;
    
    const TIPUS_EMAIL_PARTICULAR = 21;
    const TIPUS_EMAIL_TRABAJO = 22;

    const TIPUS_EMAIL = [self::TIPUS_EMAIL_PARTICULAR,self::TIPUS_EMAIL_TRABAJO];

    const TIPUS_PHONE_PARTICULAR = 1;
    const TIPUS_PHONE_TRABAJO = 2;
    const TIPUS_PHONE_MOBIL = 3;
    const TIPUS_PHONE_OTROS = 4;

    const TIPUS_PHONE = [self::TIPUS_PHONE_PARTICULAR,self::TIPUS_PHONE_TRABAJO,self::TIPUS_PHONE_MOBIL,self::TIPUS_PHONE_OTROS];
    
    protected static $root_node="perscontact";
    
    public $way;
    public $waycode;
    public $wayvalue;
    public $isdefault;
    
    protected $property_mutators= [
        "waycode" => "code",
        "wayvalue" => "value",
    ];

}
