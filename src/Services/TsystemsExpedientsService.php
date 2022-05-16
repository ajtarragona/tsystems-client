<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Helpers\TSHelpers;
use Ajtarragona\Tsystems\Models\TSPerson;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TsystemsExpedientsService extends TsystemsService
{

    protected static $application =  "BUROWEB";
    protected static $business_name =  "ExpedienteWSBC";
    protected static $data_xml_rootnode =  "ExpedienteServices";
    protected static $xml_ns =  "http://dto.exp.conecta.es";

 
    

 
    public function getExpedientByID($id){
        $ret=$this->call('ConsultaEXPByDboid',[
            'DBOID_EXP'=>$id,
        ],['request_method_prefix'=>true]);
        dd($ret);

        
    }


}