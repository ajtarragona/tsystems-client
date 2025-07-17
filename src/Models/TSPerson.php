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
    public $sex;
    public $idiom;

    public $addresses;
    public $perscontacts;


    protected $model_cast = [
        'addresses' => '\Ajtarragona\Tsystems\Models\TSAddress',
        'perscontacts' => '\Ajtarragona\Tsystems\Models\TSPersContact'
    ];

   

    public function addAdreca($address, $addresstype="API"){
        return TsystemsTercers::addAddressToPerson($this->dboid, $address,$addresstype);
    }

    public function setPhone($phone, $phonetype=null){
        return TsystemsTercers::addPhoneToPerson($this->dboid, $phone,$phonetype);
    }
    public function setPhoneParticular($phone){
        return $this->setPhone($phone, TSPersContact::TIPUS_PHONE_PARTICULAR);
    }
    public function setPhoneTrabajo($phone){
        return $this->setPhone($phone, TSPersContact::TIPUS_PHONE_TRABAJO);
    }
    public function setPhoneMobil($phone){
        return $this->setPhone($phone, TSPersContact::TIPUS_PHONE_MOBIL);
    }
    public function setPhoneOtros($phone){
        return $this->setPhone($phone, TSPersContact::TIPUS_PHONE_OTROS);
    }


    public function setEmail($email, $type=null){
        return TsystemsTercers::addEmailToPerson($this->dboid, $email, $type);
    }
    public function setEmailParticular($phone){
        return $this->setEmail($phone, TSPersContact::TIPUS_EMAIL_PARTICULAR);
    }
    public function setEmailTrabajo($phone){
        return $this->setEmail($phone, TSPersContact::TIPUS_EMAIL_TRABAJO);
    }


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
