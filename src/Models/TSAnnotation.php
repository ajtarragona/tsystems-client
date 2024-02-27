<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Facades\TsystemsRegistre;
use Ajtarragona\Tsystems\Traits\WithDBoid;
use Carbon\Carbon;

class TSAnnotation extends TSModel
{
    use WithDBoid;
    
    
    protected static $root_node="ANNOTATION";

    public $annotnumber;

    public $visiblenumber;  
    public $book;           
    public $bookcode;       
    public $regoff;      
    public $direccode;      
    public $envircode;      
    public $annotts;        

    public $intapplicants;   
    public $indicators;     
    public $variables;    
    public $bookdesc;     
    public $maname;       
    public $notifications;
    public $relatedexps;  
    public $relatedannots;
    public $creationdate; 
    public $receiver;    
    public $sir;          
    public $documents;          
    public $applicants;          


      // +"DOCUMENTS": {#6840
      //   APPLICANTS
    protected $model_cast = [
      'documents' => '\Ajtarragona\Tsystems\Models\TSDocumentRegistre',
      'applicants' => '\Ajtarragona\Tsystems\Models\TSApplicant'
    ];


    public function getJustificant($with_content=false){
      return TsystemsRegistre::getJustificant($this->dboid, $with_content);
    }
    
    public function getDocuments($with_content=false){
      return TsystemsRegistre::getAnnotationDocuments($this->dboid,$with_content);
    }
    
  
    public function getFecha($format=null){
      if(!$format) $format = "d/m/Y H:i:s";
      //2024-02-27T11:36:03.000+01:00
      return Carbon::parse($this->annotts)->format($format);
    } 

  //   public function getDocumentos(){
  //     return TsystemsExpedients::getDocumentosExpedientByID($this->dboid);
  //   }
  //   public function getTareas(){
  //     return TsystemsExpedients::getTareasExpedientByID($this->dboid);
  //   }
}