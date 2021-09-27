<?php

namespace Ajtarragona\Tsystems\Models;

class TSPerson extends TSModel
{
    protected static $root_node="person";

    public $vatacronym;
    public $idnumber;
    public $ctrldigit;
    public $name;
    public $fullname;
    public $familyname;
    public $famnamepart;
    public $secondname;
    public $secnamepart;
    public $cianame;
    public $persontype;

    public $addresses;


    protected $model_cast = [
        'addresses' => '\Ajtarragona\Tsystems\Models\TSAddress'
    ];
    
    
}
