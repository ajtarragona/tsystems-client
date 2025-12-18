<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Facades\TsystemsExpedients;
use Ajtarragona\Tsystems\Traits\WithDBoid;
use Exception;

class TSExpedient extends TSModel
{
  use WithDBoid;


  protected static $root_node = "Expediente";

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
  public $NumAnnotacion;
  protected $model_cast = [
    'documentos' => '\Ajtarragona\Tsystems\Models\TSDocumento'
  ];


  public function getDocumentos()
  {
    try {
      return TsystemsExpedients::getDocumentosExpedientByID($this->dboid);
    } catch (Exception $e) {
      return [];
    }
  }
  public function getTareas()
  {
    try {
      return TsystemsExpedients::getTareasExpedientByID($this->dboid);
    } catch (Exception $e) {
      return [];
    }
  }
  public function getPlazos()
  {
    try {
      return TsystemsExpedients::getPlazosExpedientByID($this->dboid);
    } catch (Exception $e) {
      return [];
    }
  }
  public function getAnnotations()
  {
    try {
      return TsystemsExpedients::getAnnotationsInExpedientByID($this->dboid);
    } catch (Exception $e) {
      return [];
    }
  }
  // public function getAnnotationsOut(){
  //   return TsystemsExpedients::getAnnotationsOutExpedientByID($this->dboid);
  // }
  public function getExpAsociados()
  {
    try {
      return TsystemsExpedients::getExpAsociadosExpedientByID($this->dboid);
    } catch (Exception $e) {
      return [];
    }
  }
  // public function getHojaRuta(){
  //   return TsystemsExpedients::getHojaRutaExpedientByID($this->dboid);
  // }

}
