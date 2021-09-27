<?php

namespace Ajtarragona\Tsystems\Models;

class TSCountry extends TSModel
{
    protected static $root_node="country";

    public $code;
    public $name;
    public $provcoded;
    public $vatacronym;
    public $nationality;
    public $regcoded;

}
