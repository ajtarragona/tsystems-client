<?php

namespace Ajtarragona\Tsystems\Controllers;

use Ajtarragona\Tsystems\Exceptions\TsystemsNoResultsException;
use Ajtarragona\Tsystems\Exceptions\TsystemsOperationException;
use Ajtarragona\Tsystems\Models\TSHabitante;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TsystemsPadro;

class TsystemsPadroController extends Controller
{
   
	protected $defaultfilter=[
		"nom" => "",
		"cognom1" => "",
		"cognom2" => "",
		"dni" => "",
	]; 

    protected static $pagesize=10;

    public function home( ){

       $params=[];
       $params["pagesize"] = self::$pagesize;
       $page=request()->page ?? 1;
       $empadronats=[];	
       $params["page"] = $page;
       $params["empadronats"] = $empadronats;

       try{
			
			$padrofilter=session('padrofilter',$this->defaultfilter);
			$params["padrofilter"]=json_decode(json_encode($padrofilter), FALSE);

            
            
// dd($tercersfilter);
            if($padrofilter["dni"]){
				$empadronats=TsystemsPadro::getHabitantesByDNI($padrofilter["dni"]);
			}else if($padrofilter["nom"] || $padrofilter["cognom1"] || $padrofilter["cognom2"] ){
                    

                    $empadronats=TsystemsPadro::getHabitantesByNombre(
						$padrofilter["nom"], 
						$padrofilter["cognom1"], 
						$padrofilter["cognom2"],
						[
							'pagina'=>$page
						]
					);
					
			}
			if($empadronats instanceof TSHabitante ){
				$empadronats=[$empadronats];
			}
            
			


            // $tercers = new Paginator($tercers, 5, $tercersfilter["page"] ?? 1);
                
			// dd($empadronats);
			$params["empadronats"]=$empadronats;
			
			return view("tsystems::padro.index",$params);

		}catch(TsystemsNoResultsException | TsystemsOperationException $e){
			return view("tsystems::padro.index",$params);
		}catch(Exception $e){
			// dd($e);
			$error=$e->getMessage();
			return view("tsystems::error",compact('error'));
		}
	}



	public function search(Request $request){
		//dd($request->all());
		$filter=array_merge($this->defaultfilter, $request->except(['_token','_method']));
		// dd($filter);
		session(['padrofilter'=>$filter]);
		return redirect()->route('tsystems.padro.home');
	}


	public function show($id){
		try{
			//dd($codigoDomicilio);
			$empadronat=TsystemsPadro::getHabitanteByID($id,['direccion'=>true]);
			$familiars=[];
			if($empadronat){
				$familiars=$empadronat->getFamiliars();
			}
			return view("tsystems::padro.show",compact('empadronat','familiars'));

		}catch(Exception $e){
			$error=$e->getMessage();
			return view("tsystems::error",compact('error'));
		}
	}


}