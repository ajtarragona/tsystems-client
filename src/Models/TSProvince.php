<?php

namespace Ajtarragona\Tsystems\Models;

class TSProvince extends TSModel
{
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
