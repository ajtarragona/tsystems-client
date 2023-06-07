<?php

namespace Ajtarragona\Tsystems\Controllers;

use Ajtarragona\Tsystems\Exceptions\TsystemsNoResultsException;
use Ajtarragona\Tsystems\Exceptions\TsystemsOperationException;
use Ajtarragona\Tsystems\Models\TSHabitante;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TsystemsExpedients;

class TsystemsExpedientsController extends Controller
{
   
	protected $defaultfilter=[
		"nom" => "",
		"dni" => "",
	]; 

    protected static $pagesize=10;

    public function home( ){

       $params=[];
       $params["pagesize"] = self::$pagesize;
       $page=request()->page ?? 1;
       $expedients=[];	
       $params["page"] = $page;
       $params["expedients"] = $expedients;

       try{
			
			$expedientsfilter=session('expedientsfilter',$this->defaultfilter);
			$params["expedientsfilter"]=json_decode(json_encode($expedientsfilter), FALSE);

            
            
// dd($tercersfilter);
            if($expedientsfilter["nom"]??null){
				$expedient=TsystemsExpedients::getExpedientByNumero($expedientsfilter["nom"]);
				$expedients[]=$expedient;
			}else if($expedientsfilter["dni"]??null){
				$expedients=TsystemsExpedients::getExpedientsByDNI($expedientsfilter["dni"]);
			}
			
			

            // $tercers = new Paginator($tercers, 5, $tercersfilter["page"] ?? 1);
                
			$params["expedients"]=$expedients;
			
			return view("tsystems::expedients.index",$params);

		}catch(TsystemsNoResultsException | TsystemsOperationException $e){
			$error=$e->getMessage();
			// return view("tsystems::error",compact('error'));

			return view("tsystems::expedients.index",compact('error'));
		}catch(Exception $e){
			// dd($e);
			$error=$e->getMessage();
			return view("tsystems::expedients.index",compact('error'));
			// return view("tsystems::error",compact('error'));
		}
	}



	public function search(Request $request){
		//dd($request->all());
		$filter=array_merge($this->defaultfilter, $request->except(['_token','_method']));
		// dd($filter);
		session(['expedientsfilter'=>$filter]);
		return redirect()->route('tsystems.expedients.home');
	}


	public function show($id){
		try{
			//dd($codigoDomicilio);
			$expedient=TsystemsExpedients::getExpedientByID($id);
			
			return view("tsystems::expedients.show",compact('expedient'));

		}catch(Exception $e){
			$error=$e->getMessage();
			return view("tsystems::error",compact('error'));
		}
	}


}