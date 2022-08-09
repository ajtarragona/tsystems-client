<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Facades\TsystemsExpedients;
use Ajtarragona\Tsystems\Traits\WithDBoid;

class TSExpedient extends TSModel
{
    use WithDBoid;
    
    
    protected static $root_node="Expediente";

    public $NumeroFormateado;
    public $Ejercicio;
    public $Numero;
    public $Identificador;
    public $FechaAlta;
    public $GrupoProcDesc;
    public $ProcedimientoDesc;
    public $FaseDesc;
    public $EstadoDesc;
    public $FechaEntradaUnidad;
    public $Dni;
    public $NombreCompleto;
    public $GrupoProcCode;
    public $EstadoInterno;
    public $TipoSolicitudId;
    public $TipoSolicitudDesc;
    public $CanalEntrada;
    public $Descripcion;


    public function getDocumentos(){
      return TsystemsExpedients::getDocumentosExpedientByID($this->dboid);
    }
}