<?php

namespace Ajtarragona\Tsystems\Facades; 

use Illuminate\Support\Facades\Facade;

class TsystemsRdpost extends Facade
{
    
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'tsystems-rdpost';
    }
}
