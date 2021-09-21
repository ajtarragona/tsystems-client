<?php

namespace Ajtarragona\Tsystems\Facades; 

use Illuminate\Support\Facades\Facade;

class TsystemsTercers extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'tsystems-tercers';
    }
}
