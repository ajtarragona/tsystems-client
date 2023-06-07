<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Traits\WithDBoid;

class TSAddress extends TSModel
{
    use WithDBoid;
    
    protected static $root_node="address";
    
    public $access;
    public $acronym;
    public $stname;
    public $num1;
    public $num2;
    public $dupli1;
    public $dupli2;
    public $indkm;
    public $km;
    public $indblock;
    public $block;
    public $stair;
    public $floor;
    public $door;
    public $toponymy;
    public $zipcode;
    public $fulladdress;

    //los nombres
    public $munname;
    public $provname;
    public $cntryname;
    
    //los codigos INE
    public $cntrycode;
    public $provcode;
    public $muncode;

    //los DBOID
    public $muncplty;
    public $province;
    public $country;


    protected $model_cast = [
        'access' => '\Ajtarragona\Tsystems\Models\TSAccess'
    ];


}
