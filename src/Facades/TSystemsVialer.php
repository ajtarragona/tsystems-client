<?php

namespace Ajtarragona\Tsystems\Facades; 

use Illuminate\Support\Facades\Facade;

class TsystemsVialer extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'tsystems-vialer';
    }
}
