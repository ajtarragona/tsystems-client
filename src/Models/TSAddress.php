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
    public $munname;
    public $provname;
    public $cntryname;
    



}
