<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Models\TSAcronym;
use Ajtarragona\Tsystems\Models\TSAddress;
use Ajtarragona\Tsystems\Models\TSCountry;
use Ajtarragona\Tsystems\Models\TSMunicipality;
use Ajtarragona\Tsystems\Models\TSProvince;
use Ajtarragona\Tsystems\Models\TSStreet;

class TsystemsVialerService extends TsystemsService
{

    protected static $application =  "BUROWEB";
    protected static $business_name =  "BdcServices";
    protected static $xml_ns =  "http://dto.bdt.buroweb.conecta.es";

    
    

    public function getCountriesByName($name){
        $ret=$this->call('getCountryListByStName',[
            'CNTRYNAME'=>$name
        ]);

        return TSCountry::cast($ret);
    }


    public function getAllCountries(){
        $ret=$this->call('getCountryListByStName',[
            'CNTRYNAME'=>''
        ]);

        return TSCountry::cast($ret);
    }

    public function getProvinciesByName($name, $countrycode=null){
        if(!$countrycode) $countrycode=$this->options->country_spain;

        $ret=$this->call('getProvinceListByStName',[
            'PROVNAME'=>$name,
            'COUNTRY' =>[
                'CODE' => $countrycode
            ]
            
        ]);
        // dd($ret);
        return TSProvince::cast($ret);
    }


    public function getMunicipisByName($name, $provcode=null){
        if(!$provcode) $provcode=$this->options->provincia_tarragona;

        // dd($provcode);
        $ret=$this->call('getMuncpalityListByStName',[
            'MUNNAME'=>$name,
            'PROVINCE' =>[
                'CODE' => $provcode
            ]
            
        ]);
        //TODO, parece que no pilla el codigo de provincia. Devuelve todos los municipios

        return TSMunicipality::cast($ret);
    }


    public function getMunicipiByCodi($code, $provcode=null){
        if(!$provcode) $provcode=$this->options->provincia_tarragona;

        // dd($provcode);
        $all=$this->getMunicipisByName('',$provcode);
        // dd($code, collect($all)->count());
        //no existe el metodo, recojo todos los municipios y filtro la coleccion por codigo
        return collect($all)->filter(function($municipi) use($code){
            // dump($municipi->code, $code);
            return $municipi->code == "".$code; 
        })->first();
    }

    public function getAcronymList(){
        $ret=$this->call('getAcronymList',[
            
        ]);
        // dd($ret);
        return TSAcronym::cast($ret);
    }

    public function getCarrersByName($name, $muncode=null){
        if(!$muncode) $muncode=$this->options->municipio_tarragona;
        
        $ret=$this->call('getStreetListByStName',[
            'STNAME'=>$name,
            'MUNICIPALITY' =>[
                'CODE' => $muncode
            ]
            
        ]);
        // dd($ret);
        return TSStreet::cast($ret);
    }
        
    public function getCarrerByCode($code, $muncode=null){
        if(!$muncode) $muncode=$this->options->municipio_tarragona;

        // dump("muncode",$muncode);
        // if($muncode){
        //     $municipi= self::getMu
        // }
        $ret=$this->call('getStreetByCode',[
            'STREETCODE'=>$code,
            'MUNICIPALITY' => //'101700200000651500001'
            [
                'CODE' => $muncode
            ]
            
        ],["lower_request"=>true, "lower_response"=>true]);
        // dd($ret);
        return TSStreet::cast($ret);
        
    }



    public function searchAddresses($addressparts, $muncode=null){
        if(!$muncode) $muncode=$this->options->municipio_tarragona;

        // getAddressListByOrderByAdd
        $args=[
            // 'MUNICIPALITY' => //'101700200000651500001'
            // [
            //     'CODE' => $muncode
            // ]
        ];

        if(is_string($addressparts)){
            $args=array_merge($args,[
                'STNAME'=>$addressparts
            ]);
        }else if(is_array($addressparts)){
            $args=array_merge($args,$addressparts);
        }

        $ret=$this->call(
            'getAddressListByOrderByAdd',
            $args,
            ['request_method_prefix'=>false, 'response_method_prefix'=>false,"lower_request"=>true, "lower_response"=>true]
        );
        
        return TSAddress::cast($ret);
    }

    public function createAddress($person_dboid, $address=[], $addresstype="SEGON", $muncode=null , $provcode=null, $countrycode=null){
        if(!$countrycode) $countrycode=$this->options->country_spain;
        if(!$provcode) $provcode=$this->options->provincia_tarragona;
        if(!$muncode) $muncode=$this->options->municipio_tarragona;

        $address = array_merge([
            'COUNTRY' =>[
                'CODE' => $countrycode
            ],
            'PROVINCE' =>[
                'CODE' => $provcode
            ],
            'MUNICIPALITY' =>[
                'CODE' => $muncode
            ]
        ],$address);

        $access=[
            "DBOID"=>"",
            "NUM1"=>"",
            "NUM2"=>"",
            "DUPLI1"=>"",
            "DUPLI2"=>"",
            "INDKM"=>"",
            "KM"=>"",
            "INDBLOCK"=>"",
            "FBLOCK"=>""
        ];

        $address["ACCESS"] = array_merge($access, $address["ACCESS"]);
        $args=[
            "ADDRESS" =>$address,
            "PERSONID"=> $person_dboid,
            "ADDRESSTYPE" => $addresstype
        ];
        // dd($args);
        $ret=$this->call('createAddress',
            $args,
            // ['request_method_prefix'=>false, 'response_method_prefix'=>false,"lower_request"=>true, "lower_response"=>true]
            ["lower_request"=>true, "lower_response"=>true]
        );
        
        return TSAddress::cast($ret);
    }

    // public function getAllCountries($name, $country=null){
    //     $ret=$this->call('getCountryListByStName',[
    //         'PROVNAME'=>$name,
    //     ]);

    //     return TSCountry::cast($ret);
    // }

} 