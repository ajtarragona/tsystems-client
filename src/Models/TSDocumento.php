<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Facades\TsystemsExpedients;

class TSDocumento extends TSModel
{
    
    
    protected static $root_node="Documento";

    public $Nombre;
    public $Descripcion;
    public $CUD;
    public $TipoDocumento;
    public $Autor;
}