<?php

namespace Ajtarragona\Tsystems\Services;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TsystemsTercersService
{

      public function test($name="Mundo"){
          return "HOLA, $name";
      }

}