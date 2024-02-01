<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Traits\WithDBoid;

class TSAddressRegistre extends TSModel
{
    // use WithDBoid;
    
    protected static $root_node="address_data";
    
    public $addboid;
    public $adacces;
    public $adacronym;
    public $adstname;
    public $adnum1;
    public $adnum2;
    public $addupli1;
    public $addupli2;
    public $adindkm;
    public $adkm;
    public $adindblock;
    public $adblock;
    public $adstair;
    public $adfloor;
    public $addoor;
    public $adtoponymy;
    public $adzipcode;
    public $adaddress;

    //los nombres
    public $admunname;
    public $adprovname;
    public $adcntryname;
    
    //los codigos INE
    public $adcntrycode;
    public $adprovcode;
    public $admuncode;

    //los DBOID
    public $admuncplty;
    public $adprovince;
    public $adcountry;


    // protected $model_cast = [
    //     'access' => '\Ajtarragona\Tsystems\Models\TSAccess'
    // ];


}
