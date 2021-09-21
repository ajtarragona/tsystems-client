<?php

namespace Ajtarragona\TSystems\Services;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TSystemsTercersService
{

      public function test($name="Mundo"){
          return "HOLA, $name";
      }

}