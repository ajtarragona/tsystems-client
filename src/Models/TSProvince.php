<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Traits\WithDBoid;

class TSProvince extends TSModel
{

    use WithDBoid;
    
    protected static $root_node="province";

    public $code;
    public $name;
    public $muncoded;
    public $activerec;
    public $country;


    protected $model_cast = [
        'country' => '\Ajtarragona\Tsystems\Models\TSCountry'
    ];

    
}
