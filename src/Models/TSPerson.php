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
    public $perscontacts;


    protected $model_cast = [
        'addresses' => '\Ajtarragona\Tsystems\Models\TSAddress',
        'perscontacts' => '\Ajtarragona\Tsystems\Models\TSPersContact'
    ];

   

    public function addAdreca($address, $addresstype="API"){
        return TsystemsTercers::addAddressToPerson($this->dboid, $address,$addresstype);
    }

    public function addPhone($phone, $phonetype=null){
        return TsystemsTercers::addPhoneToPerson($this->dboid, $phone,$phonetype);
    }
    public function addEmail($email, $emailtype=null){
        return TsystemsTercers::addEmailToPerson($this->dboid, $email,$emailtype);
    }
    public function getEmails(){
        if(!$this->perscontacts) return [];
        return collect($this->perscontacts)->filter(function($contact){
            return in_array(intval($contact->code), TSPersContact::TIPUS_EMAIL);
        })->pluck('value')->toArray();
    }

    public function getPhones(){
        if(!$this->perscontacts) return [];
        return collect($this->perscontacts)->filter(function($contact){
            return in_array(intval($contact->code), TSPersContact::TIPUS_PHONE);
        })->pluck('value')->toArray();
    }
    
}
