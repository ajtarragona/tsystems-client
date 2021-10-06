<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Models\TSCountry;
use Ajtarragona\Tsystems\Models\TSProvince;

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


    // public function getAllCountries($name, $country=null){
    //     $ret=$this->call('getCountryListByStName',[
    //         'PROVNAME'=>$name,
    //     ]);

    //     return TSCountry::cast($ret);
    // }

} 