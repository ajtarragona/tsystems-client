<?php

namespace Ajtarragona\Tsystems\Models;

class TSDatosPersonales extends TSModel
{
    protected static $root_node="datospersonales";

    
    public static $SEXO_HOMBRE  = 1;
    public static $SEXO_MUJER  = 6;
        
    protected $model_cast = [
        'direccion' => '\Ajtarragona\Tsystems\Models\TSDireccionHabitante'
    ];
    public $habcodind; // nia
    public $habnom; // nombre
    public $habap1hab; // primer apellido
    public $habparap1; // partícula primer apellido.
    public $habap2hab; // segundo apellido.
    public $habparap2; // partícula segundo apellido.
    public $habfecnac; // fecha nacimiento. aaaammdd
    public $habcomuna; // código municipio nacimiento
    public $habcoprna; // código provincia nacimiento
    public $habelsexo; // sexo. (1:hombre|6:mujer)
    public $habtipdoc; // tipo de documento.
    public $habnumide; // documentación.
    public $habcondig; // letra
    public $habnacion; // código ine del país de nacionalidad.
    public $habfecocu; // fecha última modificación.
    public $habdistri; // distrito
    public $habseccio; // sección
    public $habnumhoj; // número de hoja
    public $fechaalta; // fecha de alta en municipio
    public $fechaaltainscripcion; // fecha de alta en inscripción
    public $hadcodeco; // código entidad colectiva
    public $habcodecodes; // descripción entidad colectiva
    public $habcoddesi; // código entidad singular
    public $habcoddesides; // descripción entidad singular
    public $habcodnuc; // código núcleo
    public $habcodnucdes; // descripción del núcleo
    public $cun; // código único de entidad
    public $telefono; // teléfono
    public $nivelinstruccion; // nivel de instrucción
    public $feccadperm; // fecha de caducidad del permiso.
    public $direccion; // dirección. complex type tdirección.
    public $motivobaja; // código de esta en caso de tratarse de un ciudadano dado de baja en la fecha  pasada como referencia desde el parámetro fecha.
    public $habprotegido; // define si el habitante está protegido 
    public $habcodpna; // código ine del país de nacimiento
    public $habsegnacion; // código ine del país de la segunda  nacionalidad, en blanco si no setiene segunda nacionalidad 
    public $habsegnacnom; // segunda nacionalidad (nombre del país)
    public $person; // dboid de la tabla person a la que referencia el habitante, sólo visible si el parámetro (tpersparam)


}
