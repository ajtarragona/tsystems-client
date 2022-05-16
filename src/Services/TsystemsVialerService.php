<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Models\TSAcronym;
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

    // public function getAllCountries($name, $country=null){
    //     $ret=$this->call('getCountryListByStName',[
    //         'PROVNAME'=>$name,
    //     ]);

    //     return TSCountry::cast($ret);
    // }

} 