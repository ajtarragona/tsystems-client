<?php

namespace Ajtarragona\Tsystems\Controllers;

use Ajtarragona\Tsystems\Exceptions\TsystemsNoResultsException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TsystemsTercers;
use Illuminate\Pagination\Paginator;

class TsystemsTercersController extends Controller
{
    protected $defaulttercersfilter=[
		"term" => "",
		"search_type" => 1,
		"page" => 1
		
	]; 

    const TSEARCH_CONTAINS = 1;
    const TSEARCH_STARTS_WITH = 2;
    const TSEARCH_ENDS_WITH = 3;
    const TSEARCH_EQUALS = 4;
    const TSEARCH_DNI = 5;

    protected static $TSEARCHS = [
        self::TSEARCH_CONTAINS => "Conté",
        self::TSEARCH_STARTS_WITH => "Comença per",
        self::TSEARCH_ENDS_WITH => "Acaba en",
        self::TSEARCH_EQUALS => "És igual a",
        self::TSEARCH_DNI => "El Dni és",
    ];
    
    protected static $pagesize=10;

    public function home( ){

       $params=[];
       $params["tipus_search"] = self::$TSEARCHS;
       $params["pagesize"] = self::$pagesize;
       $page=request()->page ?? 1;
       $tercers=[];	
       $params["page"] = $page;
       $params["tercers"] = $tercers;

       try{
			
			$tercersfilter=session('tercersfilter',$this->defaulttercersfilter);
			$params["tercersfilter"]=json_decode(json_encode($tercersfilter), FALSE);

            
            
// dd($tercersfilter);
            if($tercersfilter["term"]){

                
                if($tercersfilter["search_type"]== self::TSEARCH_DNI){
                    $tercer=TsystemsTercers::getPersonByIdNumber($tercersfilter["term"]);
                    if($tercer) $tercers[]=$tercer;
                }else{
                    $tercers=TsystemsTercers::searchPersons($tercersfilter["term"], $tercersfilter["search_type"], $page);
                }
            }
            
			


            // $tercers = new Paginator($tercers, 5, $tercersfilter["page"] ?? 1);
                
			// dd($tercers);
			$params["tercers"]=$tercers;
			
			return view("tsystems::tercers.index",$params);

		}catch(TsystemsNoResultsException $e){
			return view("tsystems::tercers.index",$params);
		}catch(Exception $e){
			$error=$e->getMessage();
			return view("tsystems::error",compact('error'));
		}
	}



	public function search(Request $request){
		//dd($request->all());
		$filter=array_merge($this->defaulttercersfilter, $request->except(['_token','_method']));
		// dd($filter);
		session(['tercersfilter'=>$filter]);
		return redirect()->route('tsystems.tercers.home');
	}


	public function show($dboid){
		try{
			//dd($codigoDomicilio);
			$args["tercer"]=TsystemsTercers::getPersonByDboid($dboid);
			
			return view("tsystems::tercers.show",$args);

		}catch(Exception $e){
			$error=$e->getMessage();
			return view("tsystems::error",compact('error'));
		}
	}


	// public function create(){
	// 	try{
	// 		$args=[];
	// 		$args["tercer"]=new Tercer();

	// 		return view("accede-client::tercers.new",$args);

	// 	}catch(AccedeErrorException $e){
	// 		$error=$e->getMessage();
	// 		return view("accede-client::erroraccede",compact('error'));
	// 	}
	// }


	// public function newmodal(){
	// 	try{
	// 		$args=[];
	// 		$args["tercer"]=new Tercer();
	// 		$args["tipusDocuments"] = AccedeTercers::getAllTipusDocument(true);

	// 		return view("accede-client::tercers.modalnew",$args);

	// 	}catch(AccedeErrorException $e){
	// 		return response()->json([
	// 			'error' => $e->getCode(),
	// 			'message' => $e->getMessage()
	// 		], 500);
	// 	}
	// }







	// public function store(Request $request){
	// 	//dd($request->all());
	// 	//dd($tercer);
	// 	try{
			
	// 		$codigoTercero=AccedeTercers::createTercer($request->all());
			
	// 		return redirect()->route('accede.tercer.search')
	//                     ->with(['success'=>"Tercer ".$codigoTercero. "creat"]);
	//     }catch(AccedeErrorException $e){
	// 		return redirect()
    //             ->route('accede.tercer.search')
    //             ->with(['error'=>"ACCEDE: ".$e->getMessage()]); 
	// 	}catch(Exception $e){
    //        return redirect()
    //             ->route('accede.tercer.search')
    //             ->with(['error'=>"Error creant tercer"]); 
    //     }    


	// }


	// public function delete($codigoTercero){
	// 	try{
			
	// 		$ret=AccedeTercers::deleteTercer($codigoTercero);
			
	// 		return redirect()->route('accede.tercer.search')
	//                     ->with(['success'=>"Tercer ".$codigoTercero. "esborrat"]);
	//     }catch(AccedeErrorException $e){
	// 		return redirect()
    //             ->route('accede.tercer.search')
    //             ->with(['error'=>"ACCEDE: ".$e->getMessage()]); 
	// 	}catch(Exception $e){
    //        return redirect()
    //             ->route('accede.tercer.search')
    //             ->with(['error'=>"Error creant tercer"]); 
    //     }    


	// }




	// public function newdomicili($codigoTercero){
	// 	try{
	// 		$args=AccedeVialer::getCodificadors();
	// 		$args["tercer"]=AccedeTercers::getTercerById($codigoTercero);
	// 		$args["tipusDocuments"] = AccedeTercers::getAllTipusDocument(true);
	// 		$args["domicili"] = new Domicili();

	// 		return view("accede-client::tercers.modalnewdomicili",$args);

	// 	}catch(AccedeErrorException $e){
	// 		return response()->json([
	// 			'error' => $e->getCode(),
	// 			'message' => $e->getMessage()
	// 		], 500);
	// 	}
	// }


	// public function save($codigoTercero,Request $request){
	// 	//dd($request->all());
	// 	//dd($tercer);
	// 	try{
			
	// 		$tercer=Tercer::cast($request->all());	
	// 		$tercer->codigoTercero=$codigoTercero;
	// 		$tercer->setDomicilis(false,true);
			
	// 		//dd($tercer);

	// 		$return=AccedeTercers::updateTercer($tercer);

	// 		return redirect()
	//                 ->route('accede.tercer.show',[$codigoTercero])
	//                 ->with(['success'=>"Tercer modificat correctament"]); 
	//     }catch(AccedeErrorException $e){
	// 		return redirect()
    //             ->route('accede.tercer.show',[$codigoTercero])
    //             ->with(['error'=>"ACCEDE: ".$e->getMessage()]); 
	// 	}catch(Exception $e){
    //        return redirect()
    //             ->route('accede.tercer.show',[$codigoTercero])
    //             ->with(['error'=>"Error modificant tercer"]); 
    //     }    


	// }


	// public function storedomicili($codigoTercero, Request $request){
	// 	try{
			
	// 		$codigoDomicilio=AccedeVialer::createDomiciliFromRequest($request);
	// 		$tercer=AccedeTercers::getTercerById($codigoTercero);

	// 		$tercer->setDomicilis($codigoDomicilio,true);

	// 		$return=AccedeTercers::updateTercer($tercer);
	// 		//dd($tercer);
	// 		return redirect()->route('accede.tercer.show',[$codigoTercero])
	//                     ->with(['success'=>"Domicili ".$codigoDomicilio. " creat i afegit al tercer ".$codigoTercero]);
	//     }catch(AccedeNoResultsException $e){
	// 		return redirect()
    //             ->route('accede.tercer.show',[$codigoTercero])
    //             ->with(['error'=>"Has de triar el carrer"]); 
	// 	}catch(AccedeErrorException $e){
	// 		return redirect()
    //             ->route('accede.tercer.show',[$codigoTercero])
    //             ->with(['error'=>"ACCEDE: ".$e->getMessage()]); 
	// 	}catch(Exception $e){
    //        return redirect()
    //             ->route('accede.tercer.show',[$codigoTercero])
    //             ->with(['error'=>"Error creant domicili"]); 
    //     }   
			
	// }


	// public function searchdomicilis($codigoTercero, Request $request){
	// 	$args=[];
	// 	$args["domicilis"]=[];
	// 	try{
	// 		//dd($request->all());
	// 		$args["tercer"]=AccedeTercers::getTercerById($codigoTercero);
	// 		$args["domicilis"] = AccedeVialer::searchDomicilis($request->all());

	// 		return view("accede-client::tercers._searchdomicilisresults",$args);

	// 	}catch(AccedeNoResultsException $e){
	// 		return view("accede-client::tercers._searchdomicilisresults",$args);

	// 	}catch(AccedeErrorException $e){
	// 		return view("accede-client::tercers._searchdomicilisresults",$args);

	// 	}
	// }

	// public function updatedomicili($codigoTercero, $codigoDomicilio, Request $request){
	// 	try{
	// 		//dd($request->all());
	// 		$tercer=AccedeTercers::getTercerById($codigoTercero);

	// 		if($request->submitaction=="remove"){
	// 			$tercer->removeDomicili($codigoDomicilio,true);
				
				
	// 			//dd($tercer);
	// 			$return=AccedeTercers::updateTercer($tercer);
	// 			return redirect()
	//                 ->route('accede.tercer.show',[$codigoTercero])
	//                 ->with(['success'=>"Tercer modificat correctament"]); 
	//         }else if($request->submitaction=="setprincipal"){
	//         	$return=AccedeTercers::definirDomiciliPrincipal($codigoTercero, $codigoDomicilio);
	//         	return redirect()
	//                 ->route('accede.tercer.show',[$codigoTercero])
	//                 ->with(['success'=>"Tercer modificat correctament"]); 

	//         }else{
	//         	return redirect()
	//                 ->route('accede.tercer.show',[$codigoTercero]);
	//         }

	// 	}catch(AccedeNoResultsException $e){
	// 		return redirect()
    //             ->route('accede.tercer.show',[$codigoTercero])
    //             ->with(['error'=>"Has de triar el carrer"]); 
	// 	}catch(AccedeErrorException $e){
	// 		return redirect()
    //             ->route('accede.tercer.show',[$codigoTercero])
    //             ->with(['error'=>"ACCEDE: ".$e->getMessage()]); 
	// 	}catch(Exception $e){
    //        return redirect()
    //             ->route('accede.tercer.show',[$codigoTercero])
    //             ->with(['error'=>"Error creant domicili"]); 
    //     }   
	// }
	

	// public function assigndomicilis($codigoTercero, Request $request){
	// 	try{
	// 		//dd($request->all());
	// 		$tercer=AccedeTercers::getTercerById($codigoTercero);
	// 		$tercer->setDomicilis($request->codigoDomicilio,true);
			

	// 		//dd($tercer);
	// 		$return=AccedeTercers::updateTercer($tercer);
	// 		return redirect()
    //             ->route('accede.tercer.show',[$codigoTercero])
    //             ->with(['success'=>"Tercer modificat correctament"]); 

	// 	}catch(AccedeNoResultsException $e){
	// 		return redirect()
    //             ->route('accede.tercer.show',[$codigoTercero])
    //             ->with(['error'=>"Has de triar el carrer"]); 
	// 	}catch(AccedeErrorException $e){
	// 		return redirect()
    //             ->route('accede.tercer.show',[$codigoTercero])
    //             ->with(['error'=>"ACCEDE: ".$e->getMessage()]); 
	// 	}catch(Exception $e){
    //        return redirect()
    //             ->route('accede.tercer.show',[$codigoTercero])
    //             ->with(['error'=>"Error creant domicili"]); 
    //     }   
	// }

}