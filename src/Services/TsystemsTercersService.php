<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Facades\TsystemsVialer;
use Ajtarragona\Tsystems\Helpers\TSHelpers;
use Ajtarragona\Tsystems\Models\TSAddress;
use Ajtarragona\Tsystems\Models\TSPersContact;
use Ajtarragona\Tsystems\Models\TSPerson;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TsystemsTercersService extends TsystemsService
{

    protected static $application =  "BUROWEB";
    protected static $business_name =  "BdtServices";
    protected static $xml_ns =  "http://dto.bdt.buroweb.conecta.es";

    public function test($name="Mundo"){
        return $this->login();
    }

    

    /**
     *  El método devolverá la información de una persona a partir de un DNI
     */
    public function getPersonByIdNumber($dni, $addresses=true){
        $args=[
            'IDNUMBER'=>$dni
        ];
        if($addresses) $args['ALLADDRESSES']=$addresses;

        $ret=$this->call('getPersonByIdNumber', $args);
        // dump($ret);

        return TSPerson::cast($ret);
    }


    /** 
     * El método devolverá la información de una persona a partir del identificador interno Dboid
     */
    public function getPersonByDboid($dboid, $addresses=true){
         $args=[
            'DBOID'=>$dboid
        ];
        if($addresses) $args['ALLADDRESSES']=$addresses;
        
        $ret=$this->call('getPersonByDboid',$args);
        // dump($ret);

        return TSPerson::cast($ret);
    }

        
    /**
     * searchPersons
     * Busca persones a partir del nom o cognoms o nom comercial
     *
     * @param  mixed $name Nom a buscar
     * @param  mixed $search_type Tipus de cerca (1: conté, 2: comença per, 3: acabe en: 4: es igual a)
     * @param  mixed $page Número de pàgina ( 1 per defecte)
     * @return void
     */
    public function searchPersons($name, $search_type=1, $page=1){
        $term='%'.$name.'%';
        if($search_type==2) $term=$name.'%';
        else if($search_type==3) $term='%'.$name;
        else if($search_type==4) $term=$name;

        $ret=$this->call('getPersonByName',[
            'FULLNAME'=>$term,
            'PAGERESULTS' =>$page
        ],["lower_request"=>true, "lower_response"=>true]);
        // dump($ret);

        return TSPerson::cast($ret);
    }

    /**
     */

         
    /**
     * createPerson
     * Este método nos permitirá crear una nueva persona en el sistema, en caso que exista nos retornará una excepción TsystemsExistingPersonException
     * @param  mixed $persondata Array con los datos de la persona
     * @return TSPerson $person Objeto con la persona creada
     */
    public function createPerson($persondata=[]){

        // dump("createPerson",$persondata);
        TSHelpers::uppercaseKeys($persondata);
        // dump($persondata)
        $params=array_merge([
            'PERSONTYPE' => 'F',
            'VATACRONYM'=> 'ES',

        ], to_array($persondata));

        // dd($params);
        $ret=$this->call('createPerson', $params ,["lower_request"=>true,"lower_response"=>true]);
        $person=TSPerson::cast($ret);
        return $person;


        
    }


    /**
     * updatePerson
     * Este método nos permitirá modificar una persona,
     * @param  mixed $dboid Id interno de la persona
     * @param  mixed $persondata Array con los datos de la persona
     * @return TSPerson $person Objeto con la persona modificada
     */
    public function updatePerson($dboid, $persondata=[]){
 
        TSHelpers::uppercaseKeys($persondata);
        // dump($persondata)
        $params=array_merge([
            'DBOID' => $dboid,
        ], to_array($persondata));

        
        $ret=$this->call('modifyPerson', $params ,["lower_request"=>true,"lower_response"=>true]);
        $person=TSPerson::cast($ret);
        return $person;
        
    }

    
    /**
     * addAddressToPerson
     * Añade una direcció a una persona a partir de su dboid. 
     * La dirección es un array asociativo. Los campos son los del model TSAddress
     *
     * @param  mixed $person_dboid DBOID de la persona
     * @param  mixed $address array asociativo. Los campos son los del model TSAddress
     * @return TSAddress $address retorna la direccion creada
     */
    public function addAddressToPerson($person_dboid, $address=[], $addresstype="API"){
        
        return TsystemsVialer::createAddress($person_dboid, $address, $addresstype);
    }

    
    /**
     * addPhoneToPerson
     * Añade un teléfono a la persona 
     *
     * @param  mixed $dboid
     * @param  mixed $phone
     * @param  mixed $phonetype
     * @return void
     */
    public function addPhoneToPerson($dboid, $phone, $phonetype=null){
        if(!$phonetype) $phonetype=array_first(TSPersContact::TIPUS_PHONE);
        $params=[
            'PERSON_DBOID' => $dboid,
            'WAYCODE' => $phonetype,
            'WAYVALUE' => $phone,
            'ISDEFAULT' => 'F'
        ];
        $ret=$this->call('anadirMedioContacto', $params ,["lower_request"=>false,"lower_response"=>false]);
        // dd($ret);
        $contact=TSPersContact::cast($ret);
        $contact->waycode=$phonetype;
        $contact->wayvalue=$phone;
        return $contact;
    }
    
    /**
     * addEmailToPerson
     * Añade un email a la persona
     *
     * @param  mixed $dboid
     * @param  mixed $email
     * @param  mixed $emailtype
     * @return void
     */
    public function addEmailToPerson($dboid, $email, $emailtype=null){
        if(!$emailtype) $emailtype=array_first(TSPersContact::TIPUS_EMAIL);
        $params=[
            'PERSON_DBOID' => $dboid,
            'WAYCODE' => $emailtype,
            'WAYVALUE' => $email,
            'ISDEFAULT' => 'F'
        ];
        $ret=$this->call('anadirMedioContacto', $params ,["lower_request"=>false,"lower_response"=>false]);
        // dd($ret);
        $contact=TSPersContact::cast($ret);
        $contact->waycode=$emailtype;
        $contact->wayvalue=$email;
        return $contact;
    }

}