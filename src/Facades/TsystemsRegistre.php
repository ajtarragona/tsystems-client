<?php

namespace Ajtarragona\Tsystems\Facades; 

use Illuminate\Support\Facades\Facade;

class TsystemsRegistre extends Facade
{
    
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'tsystems-registre';
    }
}
