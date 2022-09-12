<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Exceptions\TsystemsNoResultsException;
use Ajtarragona\Tsystems\Exceptions\TsystemsOperationException;
use Ajtarragona\Tsystems\Models\TSExpedient;


class TsystemsRdpostService extends TsystemsService
{
    protected static $application =  "BUROWEB";
    protected static $business_name =  "ExpedienteWSBC";
    protected static $data_xml_rootnode =  "ExpedienteServices";

    protected static $xml_ns =  "http://dto.exp.conecta.es"; 



    

    public function consultaExpByIdent($options=[]) {
       try {

        // dd($options);
        $ret=$this->call('ConsultaExpByIdent',[
            'ejercicio'=>$options["ejercicio"],
            'numero'=>$options["numero"],
            'identificador'=> $options["identificador"]],
            ['request_method_prefix'=>true, 'response_method_prefix'=>true]);
        //dd($ret);

        return $ret;
           // return   $ret = TSExpedient::cast($ret);

    }

    catch(TsystemsNoResultsException $e){
        return null;
    }
    catch(TsystemsOperationException $e){
        return null;
    }
}

     public function creaActuacion($dboidExpediente, $TipoActuacionId, $contents, $name, $documentType, $mimeType ) {
       try {

       
        $documentcontent = [ 'CONTENTS'=> $contents, 'MIMETYPE' => $mimeType];
        $documentosrelacionados= ['DOCUMENTCONTENT' => $documentcontent, 'NAME'=> $name, 'DOCUMENTTYPE' => $documentType];
        $tActuacion = ['TipoActuacionId'=>$TipoActuacionId,'dboidExpediente'=>$dboidExpediente, 'documentosRelacionados' => $documentosrelacionados];
       
        $ret=$this->call('creaActuacion',['tActuacion'=> $tActuacion],
            ['request_method_prefix'=>true, 'response_method_prefix'=>true]);
     

        return $ret;
           

    }

    catch(TsystemsNoResultsException $e){
        return null;
    }
    catch(TsystemsOperationException $e){
        return null;
    }

}





}   