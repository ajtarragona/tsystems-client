<?php

namespace Ajtarragona\TSystems\Facades; 

use Illuminate\Support\Facades\Facade;

class TSystemsVialer extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'tsystems-vialer';
    }
}
