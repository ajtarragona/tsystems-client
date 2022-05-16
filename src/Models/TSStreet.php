<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Traits\WithDBoid;

class TSStreet extends TSModel
{

    use WithDBoid;
    
    protected static $root_node="street";

    public $code;
    public $acronym;
    public $stname;
    public $foncode;
    public $type;
    public $activerec;
    public $sinonim;
    public $aprobdate;
    public $observation;
    public $municipality;


    protected $model_cast = [
        'municipality' => '\Ajtarragona\Tsystems\Models\TSMunicipality'
    ];

   
    
}
