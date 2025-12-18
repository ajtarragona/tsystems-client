<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Facades\TsystemsExpedients;

class TSPlazo extends TSModel
{
    
    
    protected static $root_node="Plazo";

    public $Estado;
    public $PlazoInicial;
    public $PlazoFinal;
    public $FechaConsecucion;
    public $TipoPlazo;

      protected $model_cast = [
        'TipoPlazo' => '\Ajtarragona\Tsystems\Models\TSTipoPlazo'
    ];

}