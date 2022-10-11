<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Facades\TsystemsTercers;
use Ajtarragona\Tsystems\Traits\WithDBoid;

class TSPerson extends TSModel
{
    use WithDBoid;
    
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


    public function addAdreca($address, $addresstype="API"){
        return TsystemsTercers::addAddressToPerson($this->dboid, $address,$addresstype);
    }
    
    
}
