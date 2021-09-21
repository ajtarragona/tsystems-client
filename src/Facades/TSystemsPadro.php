<?php

namespace Ajtarragona\TSystems\Facades; 

use Illuminate\Support\Facades\Facade;

class TSystemsPadro extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'tsystems-padro';
    }
}
