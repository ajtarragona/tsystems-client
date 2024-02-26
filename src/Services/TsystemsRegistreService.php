<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Exceptions\TsystemsNoResultsException;
use Ajtarragona\Tsystems\Facades\TsystemsTercers;
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
    
    public function getJustificant($dboid, $with_content=false){
        $docs=$this->getAnnotationDocuments($dboid, $with_content);
        $tipo=config('tsystems.codigo_justif_out');

        if($docs){
            if($docs instanceof TSDocumentRegistre && $docs->documenttypecode == $tipo) return $docs;
            
            return collect($docs)->where('documenttypecode', $tipo)->first();
        }
        
        return null;
    }
    
    public function getAnnotationDocumentsByNumber($number, $llibre='E', $with_content=false){
        $annotation= $this->getAnnotationByNumber($number, $llibre);
        if($annotation) return $annotation->getDocuments($with_content);


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
    
    public function createAnnotation($content=[], $interessats=[], $documents=[], $llibre='E'){
        $book_id=$this->getLlibreId($llibre);

        $args=array_merge(
            $content,
            [
                'BOOK' => $book_id,
                'STATECODE'=>config('tsystems.STATECODE'),
                'REGOFF'=>config('tsystems.REGOFF'),
                'SOURCECODE'=>config('tsystems.SOURCECODE'),
                'DOJUSTIF' =>'true',
                'JUSTIFCODE' =>config('tsystems.JUSTIFCODE')
        ]);


        

        if($interessats){
            $args['APPLICANTS']=['APPLICANT'=>[]];

            foreach($interessats as $interessat){
                $args['APPLICANTS']['APPLICANT'][]=$interessat;
            }

        }

        if($documents){
            $args['DOCUMENTS']=[];

            foreach($documents as $document){
                $args['DOCUMENTS']['DOCUMENT'][]= $document;
                
            }

        }
          
        // dd($args);  
        $ret=$this->call('sendRequest', [
            'ANNOTATION'=>$args,

        ],['request_method_prefix'=>true, 'response_method_prefix'=>true, 'request_method_container'=>false, 'response_method_container'=>false]);
        
        // dd("RET:",$ret);
        if(isset($ret->tError)){
            throw new Exception($ret->tError->DESCRIPTION);
        }else{
            if($ret){
                return TSAnnotation::cast($ret, ['root_node'=>NULL,'forcemultiple'=>FALSE]);//$ret; //TSDocumentRegistre::cast($ret->RETURN->RETVALUE->DOCUMENTS, ['root_node'=>NULL,'forcemultiple'=>FALSE]);
            }else{
                return [];
            }
        }
    }

    public function testCreate(){
        return;
    // //si no existe la creo
        $tmp_persona=[
            "VATACRON" => "ES",
            "IDNUMBER" => "U2398667",
            "CTRLDIGIT" => "2",
            "PERSONTYPE" => "J",
            "FULLNAME" => "Empresa prueba txomin 2",
        ];


        $person=TsystemsTercers::createPerson($tmp_persona);
        // dd($person);
        $PERSON_ID=0;

        if($person){
            $PERSON_ID = $person->dboid;
        }

        if($PERSON_ID){
            $args=[
                "ABSTRACT" => "TESTTTT",
                'ANNOTGROUP'=>'900500000005271407659',
            ];
            $interessats=[
                [
                    "VATACRON" => "ES",
                    "IDNUMBER" => "U2398667",
                    "CTRLDIGIT" => "2",
                    "PRSNTYPE" => "J",
                    "ISMAINAPPLICANT" => "true",
                    "RELTYPE" => "INTERESADO",
                    "FULLNAME" => "Empresa prueba txomin 2",
                    "PERSONID" => $PERSON_ID,
                    'PERSCONTACTS'=>[
                        'PERSCONTACT' => [
                            [
                                'WAY'=>[
                                    'CODE' =>21,
                                ],
                                'WAYVALUE'=>'jandemor@piti.com',
                                'ISDEFAULT'=>TRUE
                            ]
                        ]
                    ]
                    // "ADDRESS_DATA"=>[
                    
                    //     'ADPROVNAME' => 'TARRAGONA',
                    //     'ADMUNNAME' => 'TARRAGONA',
                    //     'ADCNTRYNAME' => 'ESPAÑA',
                    //     'ADACRONYM' => 'RBLA',
                    //     'ADSTNAME' => 'VELLA',
                    //     'ADNUM1' => '1',
                    //     'ADDUPLI1' => 'B',
                    //     'ADZIPCODE' => '43003',
                        
                    // ]
                    
                ],
                // [
                //     "VATACRON" => "ES",
                //     "IDNUMBER" => "47762271",
                //     "CTRLDIGIT" => "B",
                //     "PRSNTYPE" => "F",
                //     "ISMAINAPPLICANT" => "false",
                //     "RELTYPE" => "REPRESENT.",
                //     "NAME" => "Txomin",
                //     "FAMILYNAME" => "Medrano",
                //     "SECONDNAME" => "Martorell",
                //     "PERSONID" => "2000400000095411499500"
                // ]
                
            ];
            return $this->createAnnotation($args, $interessats);
        }
    }

    public function testPdf(){
        // $file="c:\\Users\\tmedrano\\Downloads\\2010-11-cal-senzill-conserves-naturals-pere-claver-16-3r-3a-t-rrega-20240108143559.pdf";
        // $contents=base64_encode(file_get_contents($file));
        // $this->createAnnotation([
        //     "assumpte"=>"pepepepe popopo",
        //     "filename"=>"test.pdf",
        //     "filecontent"=>$contents
        // ]);

    }
    

}