<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Helpers\TSHelpers;
use Ajtarragona\Tsystems\Models\TSDocumento;
use Ajtarragona\Tsystems\Models\TSExpedient;
use Ajtarragona\Tsystems\Models\TSPerson;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TsystemsExpedientsService extends TsystemsService
{

    protected static $application =  "BUROWEB";
    protected static $business_name =  "ExpedienteWSBC";
    protected static $data_xml_rootnode =  "ExpedienteServices";
    protected static $xml_ns =  "http://dto.exp.conecta.es";

 
    

 
    public function getExpedientsByDNI($dni){
        $ret=$this->call('ListaExpbyDNI',[
            'IDNUMBER'=>$dni,
        ],['request_method_prefix'=>true, 'response_method_prefix'=>true]);
        // dump($ret);
        if(isset($ret->tError)){
            throw new Exception($ret->tError->DESCRIPTION);
        }else{
            return TSExpedient::cast($ret, ['root_node'=>'ListaExpedientes','forcemultiple'=>true]);
        }
    }

    public function getExpedientByID($id){
        $ret=$this->call('ConsultaEXPByDboid',[
            'DBOID_EXP'=>$id,
        ],['request_method_prefix'=>true, 'response_method_prefix'=>true]);
        return TSExpedient::cast($ret);

        
    }

    public function getDocumentosExpedientByID($id){
        

        $ret=$this->call('ConsultaDocumentosbyDboid',[
            'DBOID_EXP'=>$id,
        ],['request_method_prefix'=>true, 'response_method_prefix'=>true]);
       
        return TSDocumento::cast($ret, ['root_node'=>'ListaDocumentos','forcemultiple'=>true]);

        
    }
    public function getExpedientByNumero($numero){
        $ret=$this->call('ConsultaExpByIdent',[
            'expediente'=>$numero,
        ],['request_method_prefix'=>true, 'response_method_prefix'=>true]);
        return TSExpedient::cast($ret);

        
    }
    public function getExpedientByNumeroAnyo($numero,$any,$ident){
        $ret=$this->call('ConsultaExpByIdent',[
            'ejercicio'=>$any,
            'numero'=>$numero,
            'identificador'=>$ident,
        ],['request_method_prefix'=>true, 'response_method_prefix'=>true]);
        return TSExpedient::cast($ret);

        
    }

    


}