<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Traits\WithDBoid;

class TSMunicipality extends TSModel
{

    use WithDBoid;
    
    protected static $root_node="municipality";

    public $code;
    public $name;
    public $zipcode;
    public $stdcoded;
    public $province;


    protected $model_cast = [
        'province' => '\Ajtarragona\Tsystems\Models\TSProvince'
    ];

    
}
