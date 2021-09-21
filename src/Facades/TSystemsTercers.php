<?php

namespace Ajtarragona\TSystems\Facades; 

use Illuminate\Support\Facades\Facade;

class TSystemsTercers extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'tsystems-tercers';
    }
}
