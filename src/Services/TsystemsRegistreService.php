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
    
    public function getJustificant($dboid, $with_content=false){
        $docs=$this->getAnnotationDocuments($dboid, $with_content);
        if($docs){
            return collect($docs)->where('documenttypecode',"Tipo_dat_Just")->first();
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

        $args=[
            'BOOK' => $book_id,
            'ABSTRACT' =>$content['assumpte'] ?? 'Assumpte',
            'DOJUSTIF' =>'true'
        ];

        if($interessats){
            $args['APPLICANTS']=[];

            foreach($interessats as $interessat){
                $args['APPLICANTS'][]=$interessat;
                //     [
                //     'NAME'=> $interessat["nom"]??'',
                //     'FAMILYNAME'=> $interessat["cognom1"]??'',
                //     'SECONDNAME' => $interessat["cognom2"]??'',
                //     'VATACRON' => $interessat["tipus_ident"]??'ES',
                //     'IDNUMBER'=> $interessat["identificador"]??'',
                //     'CTRLDIGIT'=> $interessat["ctrl_digit"]??'',
                //     'PRSNTYPE'=> $interessat["rol_persona"]??'F',
                //     'ISMAINAPPLICANT'=> 'true',
                //     'RELTYPE'=>'INTERESADO',
                //     'ADDRESS_DATA' =>
                //         [  
                //             'ADACRONYM'=> 'CL',
                //             'ADSTNAME' => 'NOVA',
                //             'ADSNUM1' => '2',
                //             'ADZIPCODE' => '2222',
                //             'ADMUNNAME' => 'GIJON',
                //             'ADPROVNAME' => 'ASTURIAS',
                //             'ADCNTRYNAME' => 'ESPAÑA',
                //         ]
                    
                // ];
            }

        }

        if($documents){
            $args['DOCUMENTS']=[];

            foreach($documents as $document){
                $args['DOCUMENT'][]= $document;
                // [
                //     'NAME' => $document["filename"] ?? 'document',    // name    
                //     'DOCUMENTTYPE' => $document["document_type"] ?? '2017000010007794100000', // DBOID DE LA TABLA TPERSDOCTYPE
                //     'DOCUMENTCONTENT'=>[
                //         'CONTENTS' => $document["filecontent"], //base64 archivo
                //         'MIMETYPE' => $document["mimetype"] ?? "application/pdf",
                //     ],
                //     'DESCRIPTION' => $document["description"]??'',
                // ];
            }

        }
          
        
        $ret=$this->call('sendRequest', [
            'ANNOTATION'=>$args,

        ],['request_method_prefix'=>true, 'response_method_prefix'=>true, 'request_method_container'=>false, 'response_method_container'=>false]);
        
        // dump($ret);
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

    public function testPdf(){
        $file="c:\\Users\\tmedrano\\Downloads\\2010-11-cal-senzill-conserves-naturals-pere-claver-16-3r-3a-t-rrega-20240108143559.pdf";
        $contents=base64_encode(file_get_contents($file));
        $this->createAnnotation([
            "assumpte"=>"pepepepe popopo",
            "filename"=>"test.pdf",
            "filecontent"=>$contents
        ]);

    }
    

}