<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Traits\WithDBoid;

class TSCountry extends TSModel
{
    use WithDBoid;
    
    protected static $root_node="country";

    public $code;
    public $name;
    public $provcoded;
    public $vatacronym;
    public $nationality;
    public $regcoded;

}
