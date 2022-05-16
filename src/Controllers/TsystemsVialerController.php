<?php

namespace Ajtarragona\Tsystems\Controllers;

use Ajtarragona\Tsystems\Exceptions\TsystemsNoResultsException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TsystemsVialer;
use Illuminate\Pagination\Paginator;

class TsystemsVialerController extends Controller
{
   
    public function home( Request $request ){

		$params=[];
		$carrers=[];
		$params["carrers"] = $carrers;

		
 
		try{
			 
			 $term=session('vialerfilter');
			 $params["term"] = $term;
			 
			 if($params["term"]){
 				$carrers=TsystemsVialer::getCarrersByName($params["term"]);
			 }
			 $params["carrers"] = $carrers;

			 return view("tsystems::vialer.index",$params);
 
		 }catch(TsystemsNoResultsException $e){
			 return view("tsystems::vialer.index",$params);
		 }catch(Exception $e){
			 $error=$e->getMessage();
			 return view("tsystems::error",compact('error'));
		 }
	 }
 
 
 
	 public function search(Request $request){
		 session(['vialerfilter'=>$request->term]);
		 return redirect()->route('tsystems.vialer.home');
	 }

	public function combo(Request $request){
		
	}


}