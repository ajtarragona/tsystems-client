<?php

namespace Ajtarragona\Tsystems\Models;

class TSInstitucion extends TSModel
{
    protected static $root_node="institucion";

    public $oidparins;

    public function __construct($oidparins=null)
    {
        $this->oidparins = $oidparins;
    }
}
