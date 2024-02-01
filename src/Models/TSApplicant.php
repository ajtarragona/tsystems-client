<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Facades\TsystemsTercers;
use Ajtarragona\Tsystems\Traits\WithDBoid;

class TSApplicant extends TSModel
{
    // use WithDBoid;
    
    protected static $root_node="applicant";

    public $personid;
    public $vatacron;
    public $idnumber;
    public $ctrldigit;
    public $name;
    // public $fullname;
    public $familyname;
    public $secondname;
    // public $secnamepart;
    public $cianame;
    public $prsntype;
    public $party;
    public $ismainapplicant;
    public $municipality;


    public $address_data;
    public $perscontacts;


    protected $model_cast = [
        'address_data' => '\Ajtarragona\Tsystems\Models\TSAddressRegistre',
        'perscontacts' => '\Ajtarragona\Tsystems\Models\TSPersContact'
    ];

   


    protected function getMedioContacto($tipus, $single=false){
        if(!$this->perscontacts) return [];
        if(!is_array($tipus)) $tipus=[$tipus];
        // dump($this->perscontacts);
        if($this->perscontacts){
            //si solo hay uno
            if($this->perscontacts instanceof TSPersContact)  $this->perscontacts=[$this->perscontacts];

            $ret=collect($this->perscontacts)->filter(function($contact) use ($tipus){
                return $contact && in_array(intval($contact->code), $tipus);
            });
            if($single) return $ret->first();
            else return $ret->toArray();
        }
        return null;

    }

    public function getEmails(){
       return $this->getMedioContacto(TSPersContact::TIPUS_EMAIL);
    }

    public function getPhones(){
        return $this->getMedioContacto(TSPersContact::TIPUS_PHONE);
    }

    public function getEmailParticular(){
        return $this->getMedioContacto(TSPersContact::TIPUS_EMAIL_PARTICULAR, true)->value ??null;
    }

    public function getEmailTrabajo(){
        return $this->getMedioContacto(TSPersContact::TIPUS_EMAIL_TRABAJO, true)->value ??null;
    }

    public function getPhoneParticular(){
        return $this->getMedioContacto(TSPersContact::TIPUS_PHONE_PARTICULAR, true)->value ??null;
    }

    public function getPhoneTrabajo(){
        return $this->getMedioContacto(TSPersContact::TIPUS_PHONE_TRABAJO, true)->value ??null;
    }

    public function getPhoneMobil(){
        return $this->getMedioContacto(TSPersContact::TIPUS_PHONE_MOBIL, true)->value ??null;
    }

    public function getPhoneOtro(){
        return $this->getMedioContacto(TSPersContact::TIPUS_PHONE_OTROS, true)->value ??null;
    }
    
}
