<?php

namespace Ajtarragona\Tsystems\Models;


class TSExpedientAnnotation extends TSModel
{
    
    protected static $root_node="Annotation";

    public $Dboid;
    public $Anyo;
    public $NumeroAnotacion;
    public $FechaRegistro;
    public $FechaEntradaUnid;
    public $DniInteresado;
    public $NombreInteresado;
    public $AnnotationId;
    public $Extracto;
    public $SentidoCode;
    public $VisibleNum;

}