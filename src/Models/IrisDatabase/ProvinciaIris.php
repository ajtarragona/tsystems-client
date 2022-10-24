<?php
namespace Ajtarragona\Tsystems\Models\IrisDatabase;

use Illuminate\Database\Eloquent\Model;

class ProvinciaIris extends Model
{
    
    protected $primaryKey = 'CODE';
    public $incrementing = false;
    public $timestamps = false;


    public $connection = 'tsystems_tdata_pro';
    public $table = 'IND_04403';

  
    public $dates = ["PROC"];
   
    public $sortable = [
        "PROC", "CODE","NAME","CODREG","NOMREG"
    ];
 
 
      
   protected $fillable = [
      "CODE","NAME"
   ];


   public function scopeSearch( $query, $name){
      $query->where('NAME','like','%'.$name.'%')->orWhere('CODE',$name);
   }
 

}
