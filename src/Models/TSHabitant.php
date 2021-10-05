<?php

namespace Ajtarragona\Tsystems\Models;

class TSHabitant extends TSModel
{
    protected static $root_node="habitante";

    
    public static $SEXO_HOMBRE  = 1;
    public static $SEXO_MUJER  = 6;
        
    public $datospersonales;
    
    protected $model_cast = [
        'datospersonales' => '\Ajtarragona\Tsystems\Models\TSDatosPersonales'
    ];
    
}