<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Models\TSPerson;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TsystemsTercersService extends TsystemsService
{

    public function test($name="Mundo"){
        return $this->login();
    }


    /**
     *  El método devolverá la información de una persona a partir de un DNI
     */
    public function getPersonByIdNumber($dni){
        $ret=$this->call('getPersonByIdNumber',[
            'IDNUMBER'=>$dni,
            'ALLADDRESSES'=>true
        ]);
        // dump($ret);

        return TSPerson::cast($ret);
    }

    /** 
     * El método devolverá la información de una persona a partir del identificador interno Dboid
     */
    public function getPersonByDboid($dboid){

    }

    /**
     * El método devolverá la información de una o muchas personas a partir del nombre
     */
    public function getPersonByName($name){
        
    }

    /**
     * Este método nos permitirá crear una nueva persona en el sistema, en caso que exista nos retornará la existente
     */
    public function createPerson(){
        
    }
}