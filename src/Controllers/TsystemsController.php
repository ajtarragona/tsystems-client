<?php

namespace Ajtarragona\Tsystems\Controllers; 

use Illuminate\Routing\Controller;

class TsystemsController extends Controller
{
        
    public function home( ){

        return view('tsystems::home');
       
    }
}