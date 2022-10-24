<?php
namespace Ajtarragona\Tsystems\Models\IrisDatabase;

use Illuminate\Database\Eloquent\Model;

class PaisIris extends Model
{
    
    protected $primaryKey = 'CODE';
    public $incrementing = false;
    public $timestamps = false;


    public $connection = 'tsystems_tdata_pro';
    public $table = 'IND_04401';

  
    public $dates = ["PROC"];
   
    public $sortable = [
        "PROC", "CODE","NAME"
    ];
 
 
      
   protected $fillable = [
      "CODE","NAME"
   ];


   public function scopeSearch( $query, $name){
      $query->where('NAME','like','%'.$name.'%')->orWhere('CODE',$name);
   }
 

}
