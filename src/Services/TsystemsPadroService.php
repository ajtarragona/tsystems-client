<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Exceptions\TsystemsNoResultsException;
use Ajtarragona\Tsystems\Exceptions\TsystemsOperationException;
use Ajtarragona\Tsystems\Models\TSHabitante;
use Ajtarragona\Tsystems\Models\TSHabitanteResponse;
use Ajtarragona\Tsystems\Models\TSInstitucion;
use Ajtarragona\Tsystems\Models\TSTipoDocumento;

class TsystemsPadroService extends TsystemsService
{
    protected static $application =  "EPOB";
    protected static $business_name =  "ConectaVolanteePobBC";
    protected static $data_xml_rootnode =  "PoblacionServices";
    protected static $xml_ns =  "http://dto.poblacion.conecta.es";
      

  
    


    public function getCurrentInstitucion(){
        if($this->options->oidparins){
            return new TSInstitucion($this->options->oidparins);
        }else{
            return $this->getInstitucion();
        }
    }

    public function getInstitucion($codigoProvincia=null, $codigoMunicipio=null){

        $ret=$this->call('getInstitucion',[
            'CODIGOPROVINCIA'=>$codigoProvincia ? $codigoProvincia : $this->options->provincia_tarragona,
            'CODIGOMUNICIPIO'=>$codigoMunicipio ? $codigoMunicipio : $this->options->municipio_tarragona,
        ],['request_method_prefix'=>true, 'response_method_prefix'=>true]);
        // dd($ret);

        return TSInstitucion::cast($ret);
    }
    
    
    public function getHabitanteByID($id, $options=[]){
        $options= to_object(array_merge([
            'direccion'=>  false,
            'incluye_baja'=>  false,
            'pdf'=>  false,
            'pdflang'=>  'CA'
        ], $options));

        $institucion =  $this->getCurrentInstitucion();
        if($institucion && $institucion->oidparins){
            $args=[
                'OIDPARINS'=>$institucion->oidparins,
                'NIA'=>$id,
                'NIVEL'=>  $options->direccion?2:1,
                'INCLUYEBAJA'=>  $options->incluye_baja?1:0,
                'PDF'=>  $options->pdf?1:0,
                'PDFLANG'=>  $options->pdflang
            ];
            // dd($args);
            $ret=$this->call('getHabitanteByNIA',$args,['request_method_prefix'=>true, 'response_method_prefix'=>true]);
        //    dd($ret);
            
            // dump($ret);
            if($options->pdf){
                return $ret->PDF;
            }else{
                $ret = TSHabitanteResponse::cast($ret);
                return $ret->habitant ?? null;
            }
        }
    }

        
    /**
     * getPDFHabitanteByID
     * Retorna el PDF del habitante
     *
     * @param  mixed $id
     * @param  mixed $options
     * @return void
     */
    public function getPDFHabitanteByID($id, $options=[]){
        return $this->getHabitanteByID($id, array_merge($options, ["pdf"=>true]));
    }

    /**
     *  El método devolverá la información de una persona a partir de un DNI
     */
    public function getHabitanteByDNI($dni, $options=[]){
        $options= to_object(array_merge([
            'tipdoc' => TSTipoDocumento::DNI,
            'direccion'=>  false,
            'incluye_baja'=>  false,
            'pdf'=>  false,
            'pdflang'=>  'CA',
            'fecha'=>false
        ], $options));

        $institucion =  $this->getCurrentInstitucion();
        if($institucion && $institucion->oidparins){
            $ret=$this->call('getHabitanteByDNI',[
                'OIDPARINS'=>$institucion->oidparins,
                'IDNUMBER'=>$dni,
                'TIPODOC'=> $options->tipdoc,
                'NIVEL'=>  $options->direccion?2:1,
                'INCLUYEBAJA'=>  $options->incluye_baja?1:0,
                'FECHA' => $options->fecha ? $options->fecha : date('Ymd'),  
                'PDF'=>  $options->pdf?1:0,
                'PDFLANG'=>  $options->pdflang
            ],['request_method_prefix'=>true, 'response_method_prefix'=>true]);
        //    dd($ret);
            
            // dump($ret);
            if($options->pdf){
                return $ret->PDF;
            }else{
                $ret = TSHabitanteResponse::cast($ret);
                return $ret->habitant ?? null;
            }
        }
    }


    public function getPDFHabitanteByDNI($dni, $options=[]){
        return $this->getHabitanteByDNI($dni, array_merge($options, ["pdf"=>true]));
    }

  


    private function getHabitantesByDocumento($dni, $options=[]){
        $options= to_object(array_merge([
            'tipdoc' => TSTipoDocumento::DNI,
            'direccion'=>  false,
            'incluye_baja'=>  false,
            'fecha' => false,
            'pagina'=>  1,
            'count'=> false
        ], $options));

        $institucion =  $this->getCurrentInstitucion();
        // dd($institucion);
        if($institucion && $institucion->oidparins){
            $ret=$this->call('getListHabitanteByDNI',[
                'ODPARINS'=>$institucion->oidparins, // OJO OD, no  OID
                'IDNUMBER'=>$dni,
                'TIPODOC'=> $options->tipdoc,
                'NIVEL'=>$options->count ? 0 : ($options->direccion?2:1),
                'INCLUYEBAJA'=>  $options->incluye_baja?1:0,
                'FECHA' => $options->fecha ? $options->fecha : date('Ymd'),  
                'PAGENUMBER'=>$options->pagina?$options->pagina:1,
                
            ],['request_method_prefix'=>true, 'response_method_prefix'=>true]);
            // dump($ret);
            if($options->count){
                return intval($ret->EMPADRONADO??0);
            }else{
                $ret = TSHabitanteResponse::cast($ret);
                return $ret->habitant ?? null;
            }
        }
    }

    

    public function getHabitantesByDNI($id, $options=[]){
        return $this->getHabitantesByDocumento($id, array_merge($options,['tipdoc'=>TSTipoDocumento::DNI]));
    }
    public function getHabitantesByPasaporte($id, $options=[]){
        return $this->getHabitantesByDocumento($id, array_merge($options,['tipdoc'=>TSTipoDocumento::PASAPORTE]));
    }
    
    public function getHabitantesByTarjetaResidencia($id, $options=[]){
        return $this->getHabitantesByDocumento($id, array_merge($options,['tipdoc'=>TSTipoDocumento::TARJETA_RESIDENCIA]));
    }

    public function getNumHabitantesByDNI($id , $options=[]){
        return $this->getHabitantesByDocumento($id, array_merge($options,['count'=>true, 'tipdoc'=>TSTipoDocumento::DNI]));
    }

    public function getNumHabitantesByPasaporte($id , $options=[]){
        return $this->getHabitantesByDocumento($id, array_merge($options,['count'=>true,'tipdoc'=>TSTipoDocumento::PASAPORTE]));
    }

    public function getNumHabitantesByTarjetaResidencia($id , $options=[]){
        return $this->getHabitantesByDocumento($id, array_merge($options,['count'=>true,'tipdoc'=>TSTipoDocumento::TARJETA_RESIDENCIA]));
    }




    public function getHabitantesByNombre($nombre, $apellido1, $apellido2,  $options=[]){
       
        $options= to_object(array_merge([
            'direccion'=>  false,
            'incluye_baja'=>  false,
            'c'=>  1,
            'count'=>false,
            'fecha'=>false
        ], $options));


        $institucion =  $this->getCurrentInstitucion();

        if($institucion && $institucion->oidparins){
            $ret=$this->call('getListHabitanteByName',[
                'OIDPARINS'=>$institucion->oidparins,
                'NOMBRE'=> strtoupper($nombre),
                'APELLIDO1'=>strtoupper($apellido1),
                'APELLIDO2'=>strtoupper($apellido2),
                'NIVEL'=>$options->count ? 0 : ($options->direccion?2:1),
                'INCLUYEBAJA'=>  $options->incluye_baja?1:0,
                'FECHA' => $options->fecha ? $options->fecha : date('Ymd'),  
                'PAGENUMBER'=>$options->pagina?$options->pagina:1,
                
            ],['request_method_prefix'=>true, 'response_method_prefix'=>true]);

            // dump($ret);
            if($options->count){
                return intval($ret->EMPADRONADO??0);
            }else{
                $ret = TSHabitanteResponse::cast($ret);
                // dd($ret);
                if($ret){
                    if($ret->habitant instanceof TSHabitante){
                        return [$ret->habitant];
                    }else{
                        return collect($ret)->pluck('habitant')->toArray() ?? [];
                    }
                }else{
                    return [];
                }
            }
        }
    }




    public function getNumHabitantesByNombre($nombre, $apellido1, $apellido2 , $options=[]){
        try{
            return $this->getHabitantesByNombre($nombre, $apellido1, $apellido2, array_merge($options,['count'=>true]));
        }catch(TsystemsNoResultsException $e){
            return 0;
        }
    }


    public function getFamiliaHabitanteByDNI($dni , $options=[]){
            
        $options= to_object(array_merge([
            'tipdoc' => TSTipoDocumento::DNI,
            'direccion'=>  false,
            'pdf'=>  false,
            'pdflang'=>  'CA'
        ], $options));

        $institucion =  $this->getCurrentInstitucion();
        if($institucion && $institucion->oidparins){
            $ret=$this->call('getFamiliaHabitanteByDNI',[
                'OIDPARINS'=>$institucion->oidparins,
                'IDNUMBER'=>$dni,
                'TIPODOC'=> $options->tipdoc,
                'NIVEL'=>  $options->direccion?2:1,
                'PDF'=>  $options->pdf?1:0,
                'PDFLANG'=>  $options->pdflang
            ],['request_method_prefix'=>true, 'response_method_prefix'=>true]);
        //    dd($ret);
            
            // dump($ret);
            if($options->pdf){
                return $ret->PDF;
            }else{
                $ret=TSHabitanteResponse::cast($ret);
                return $ret->familiars ?? [];
                
            }
        }
        
    }


    public function getFamiliaHabitanteByID($id , $options=[]){
            
        $options= to_object(array_merge([
            'direccion'=>  false,
            'pdf'=>  false,
            'pdflang'=>  'CA'
        ], $options));

        $institucion =  $this->getCurrentInstitucion();
        if($institucion && $institucion->oidparins){
            $ret=$this->call('getFamiliaHabitanteByNIA',[
                'OIDPARINS'=>$institucion->oidparins,
                'NIA'=>$id,
                'NIVEL'=>  $options->direccion?2:1,
                'PDF'=>  $options->pdf?1:0,
                'PDFLANG'=>  $options->pdflang
            ],['request_method_prefix'=>true, 'response_method_prefix'=>true]);
        //    dd($ret);
            
            // dump($ret);
            if($options->pdf){
                return $ret->PDF;
            }else{
                $ret=TSHabitanteResponse::cast($ret);
                return $ret->familiars ?? [];
                
            }
        }
        
    }


}   