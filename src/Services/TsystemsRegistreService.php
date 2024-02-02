<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Exceptions\TsystemsNoResultsException;
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
 
    

 
    public function getLlibreId($llibre){
       return (strtoupper($llibre)=="E" ) ? config('tsystems.book_in_id') : config('tsystems.book_out_id');
    }

    public function getAnnotationByNIF($nif, $llibre='E'){
        $book_id=$this->getLlibreId($llibre);

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
            if(isset($ret->ANNOTATION)){
               return TSAnnotation::cast($ret, ['root_node'=>NULL,'forcemultiple'=>FALSE]);
            }else{
                throw new TsystemsNoResultsException("No annotations");
            }
        }
    }


    public function getAnnotationByNumber($number, $llibre='E'){
        
        $book_id=$this->getLlibreId($llibre);

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
            
            if(isset($ret->ANNOTATION)){
                return TSAnnotation::cast($ret, ['root_node'=>NULL,'forcemultiple'=>FALSE]);
            }else{
                throw new TsystemsNoResultsException("No annotations");
            }
        }
    }
    
    public function getJustificant($dboid){
        $docs=$this->getAnnotationDocuments($dboid);
        if($docs){
            return collect($docs)->where('documenttypecode',"Tipo_dat_Just")->first();
        }
        return null;
    }
    
    public function getAnnotationDocuments($dboid, $with_content=false){
        $ret=$this->call($with_content ? 'getAnnotationDocuments' : 'getAnnotationDocumentHeaders',[
            'ANNOTATION'=>[
                'DBOID'=>$dboid
            ],
        ],['request_method_prefix'=>true, 'response_method_prefix'=>true, 'request_method_container'=>false, 'response_method_container'=>false]);
        
        // dd($ret);
        if(isset($ret->tError)){
            throw new Exception($ret->tError->DESCRIPTION);
        }else{
            if($ret->RETURN->RETVALUE->DOCUMENTS ??null){
                return TSDocumentRegistre::cast($ret->RETURN->RETVALUE->DOCUMENTS, ['root_node'=>NULL,'forcemultiple'=>FALSE]);
            }else{
                return [];
            }
        }
    }
    
    public function createAnnotation($content=[], $llibre='E'){
        $book_id=$this->getLlibreId($llibre);

        $ret=$this->call('sendRequest', [
            'ANNOTATION'=>[
                'BOOK' => $book_id,
                'ABSTRACT' =>'Lalalala',
                'APPLICANTS'=>[
                    'APPLICANT'=>[
                        'NAME'=>'Test',
                        'FAMILYNAME'=>'Testinyo',
                        'SECONDNAME' =>'Probando',
                        'VATACRON' =>'ES',
                        'IDNUMBER'=>'11111112',
                        'CTRLDIGIT'=>'L',
                        'PRSNTYPE'=>'F',
                        'ISMAINAPPLICANT'=> 'true',
                        'RELTYPE'=>'INTERESADO',
                        'ADDRESS_DATA' =>
                            [  
                                'DACRONYM'=> 'CL',
                                'ADSTNAME' => 'NOVA',
                                'ADSNUM1' => '2',
                                'ADZIPCODE' => '2222',
                                'ADMUNNAME' => 'GIJON',
                                'ADPROVNAME' => 'ASTURIAS',
                                'ADCNTRYNAME' => 'ESPAÑA',
                            ]
                        
                    ]
                ]
            ],

        ],['request_method_prefix'=>true, 'response_method_prefix'=>true, 'request_method_container'=>false, 'response_method_container'=>false]);
        
        dd($ret);
        if(isset($ret->tError)){
            throw new Exception($ret->tError->DESCRIPTION);
        }else{
            if($ret->RETURN->RETVALUE->DOCUMENTS ??null){
                return TSDocumentRegistre::cast($ret->RETURN->RETVALUE->DOCUMENTS, ['root_node'=>NULL,'forcemultiple'=>FALSE]);
            }else{
                return [];
            }
        }
    }
    

}