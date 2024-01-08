<?php
namespace Ajtarragona\Tsystems\Models\IrisDatabase;

use Illuminate\Database\Eloquent\Model;

class MunicipiIris extends Model
{
    
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;


    public $connection = 'tsystems_tdata_pro';
    public $table = 'IND_04404';

  
    public $dates = ["PROC"];
   
    public $sortable = [
         "DBOID", "PROC", "CODE","NAME","CODPROV","NOMPROV"
    ];
 
      
   protected $fillable = [
      "CODE","NAME"
   ];

   public function scopeSearch( $query, $name){
      $query->where('NAME','like','%'.$name.'%')->orWhere('CODE',$name);
   }

   public function scopeOfProvincia( $query, $codprov){
      $query->where('CODPROV',$codprov);
   }
   public function scopeNotExcluded( $query){
      $excluded=config("tsystems.excluded_municipios",[]);
      if($excluded){
         $query->whereNotIn('CODE',$excluded);
      }
   }
}
