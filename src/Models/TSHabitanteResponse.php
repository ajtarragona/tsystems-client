<?php

namespace Ajtarragona\Tsystems\Models;

class TSHabitanteResponse extends TSModel
{
    protected static $root_node="habitante";

    
    public static $SEXO_HOMBRE  = 1;
    public static $SEXO_MUJER  = 6;
        
    public $datospersonales;
    public $datosfamiliares;
    
    protected $model_cast = [
        'datospersonales' => '\Ajtarragona\Tsystems\Models\TSHabitante',
        'datosfamiliares' => '\Ajtarragona\Tsystems\Models\TSHabitante'
    ];

    protected $property_mutators= [
        "datospersonales" => "habitant",
        "datosfamiliares" => "familiars",
    ];
    
}