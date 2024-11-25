<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Traits\WithDBoid;

class TSAccess extends TSModel
{
    use WithDBoid;
    
    protected static $root_node="access";
    
    public $num1;
    public $num2;
    public $dupli1;
    public $dupli2;
    public $indkm;
    public $km;
    public $indblock;
    public $block;
    public $fblock;
    public $stair;
    public $floor;
    public $door;
    public $toponymy;
    public $zipcode;
    public $accesstype;
  
   


}
