<?php

namespace Ajtarragona\Tsystems\Facades; 

use Illuminate\Support\Facades\Facade;

class TsystemsPadro extends Facade
{
    
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'tsystems-padro';
    }
}
