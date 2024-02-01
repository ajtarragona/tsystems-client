<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Helpers\A2XML;
use Ajtarragona\Tsystems\Helpers\Array2XML;
use Ajtarragona\Tsystems\Helpers\TSHelpers;
use Ajtarragona\Tsystems\Models\TSAnnotation;
use Ajtarragona\Tsystems\Models\TSDocumento;
use Ajtarragona\Tsystems\Models\TSDocumentRegistre;
use Ajtarragona\Tsystems\Models\TSExpedient;
use Ajtarragona\Tsystems\Models\TSPerson;
use DOMDocument;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleXMLElement;
use XMLParser\XMLParser;

class TsystemsRegistreService extends TsystemsService
{

    protected static $application =  "REGISTRA";
    protected static $business_name =  "RequestBusinessComponent";
    protected static $data_xml_rootnode =  "REGIS";
    protected static $xml_ns =  "http://dto.ereg.conecta.es";
 
    

 
    public function getAnnotationByNIF($nif, $llibre='E'){
        $book_id = (strtoupper($llibre)=="E" ) ? config('tsystems.book_in_id') : config('tsystems.book_out_id');
        $ret=$this->call('selectAnnotations',[
            'SELECTIONCRITERIA'=>[
                'CRITERIAITEM'=>[
                    [
                        'FIELD' => 'BOOK',
                        'OPERATOR' => '=',
                        'VALUE' => $book_id,
                        'LOGICOPERATOR' => 'AND'
                    ]
                ],
                'WHERE' => "annotappl.idnumber = '".$nif."'"
                
            ],
        ],['request_method_prefix'=>true, 'response_method_prefix'=>true, 'request_method_container'=>false, 'response_method_container'=>false]);

        if(isset($ret->tError)){
            throw new Exception($ret->tError->DESCRIPTION);
        }else{
            // dd($ret);
            return TSAnnotation::cast($ret, ['root_node'=>NULL,'forcemultiple'=>FALSE]);
        }
    }


    public function getAnnotationByNumber($number, $llibre='E'){
        
        $book_id = (strtoupper($llibre)=="E" ) ? config('tsystems.book_in_id') : config('tsystems.book_out_id');

        $ret=$this->call('selectAnnotations',[
            'SELECTIONCRITERIA'=>[
                'CRITERIAITEM'=>[
                    [
                        'FIELD' => 'BOOK',
                        'OPERATOR' => '=',
                        'VALUE' => $book_id,
                        'LOGICOPERATOR' => 'AND'
                        ]
                    ],
                'WHERE' => "annotnumber ".(is_array($number) ? 'in':'=')." ".(is_array($number) ? "('".implode("','",$number)."')":"'".$number."'")
                
            ],
        ],['request_method_prefix'=>true, 'response_method_prefix'=>true, 'request_method_container'=>false, 'response_method_container'=>false]);
        // dump($ret);
        if(isset($ret->tError)){
            throw new Exception($ret->tError->DESCRIPTION);
        }else{
            // dd($ret);
            return TSAnnotation::cast($ret, ['root_node'=>NULL,'forcemultiple'=>FALSE]);
        }
    }
    
    public function getJustificant($dboid){
        $docs=$this->getAnnotationDocuments($dboid);
        if($docs){
            return collect($docs)->where('documenttypecode',"Tipo_dat_Just")->first();
        }
        return null;
    }
    
    public function getAnnotationDocuments($dboid){
        $ret=$this->call('getAnnotationDocuments',[
            'ANNOTATION'=>[
                'DBOID'=>$dboid
            ],
        ],['request_method_prefix'=>true, 'response_method_prefix'=>true, 'request_method_container'=>false, 'response_method_container'=>false]);
        
        // dd($ret);
        if(isset($ret->tError)){
            throw new Exception($ret->tError->DESCRIPTION);
        }else{
            // dd($ret->RETURN->RETVALUE->DOCUMENTS);
            return TSDocumentRegistre::cast($ret->RETURN->RETVALUE->DOCUMENTS, ['root_node'=>NULL,'forcemultiple'=>FALSE]);
        }
    }
    


}