<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Helpers\TSHelpers;
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
        $ret=$this->call('getPersonByIdNumber',[
            'IDNUMBER'=>$dni,
            'ALLADDRESSES'=>$addresses
        ]);
        // dump($ret);

        return TSPerson::cast($ret);
    }


    /** 
     * El método devolverá la información de una persona a partir del identificador interno Dboid
     */
    public function getPersonByDboid($dboid, $addresses=true){
        $ret=$this->call('getPersonByDboid',[
            'DBOID'=>$dboid,
            'ALLADDRESSES'=>$addresses
        ]);
        // dump($ret);

        return TSPerson::cast($ret);
    }

        
    /**
     * searchPersons
     * Busca persones a partir del nom o cognoms o nom comercial
     *
     * @param  mixed $name Nom a buscar
     * @param  mixed $search_type Tipus de cerca (1: conté, 2: comença per, 3: acabe en: 4: es igual a)
     * @return void
     */
    public function searchPersons($name, $search_type=1){
        $term='%'.$name.'%';
        if($search_type==2) $term=$name.'%';
        else if($search_type==3) $term='%'.$name;
        else if($search_type==4) $term=$name;

        $ret=$this->call('getPersonByName',[
            'FULLNAME'=>$term,
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

 
        TSHelpers::uppercaseKeys($persondata);
        // dump($persondata)
        $params=array_merge([
            'PERSONTYPE' => 'F',
            'VATACRONYM'=> 'ES',

        ], to_array($persondata));

        
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
}