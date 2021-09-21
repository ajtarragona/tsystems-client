<?php

namespace Ajtarragona\TSystems;

use Illuminate\Support\ServiceProvider;
//use Illuminate\Support\Facades\Blade;
//use Illuminate\Support\Facades\Schema;

class TSystemsServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        

        //cargo rutas
        $this->loadRoutesFrom(__DIR__.'/routes.php');


        //publico configuracion         
        $this->publishes([
            __DIR__.'/Config/tsystems.php' => config_path('tsystems.php'),
        ], 'ajtarragona-tsystems-config');

        

        
        


       
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       	
        //defino facades
        $this->app->bind('tsystems-tercers', function(){
            return new \Ajtarragona\TSystems\TSystemsTercersService;
        });
        $this->app->bind('tsystems-vialer', function(){
            return new \Ajtarragona\TSystems\TSystemsVialerService;
        });
        $this->app->bind('tsystems-padro', function(){
            return new \Ajtarragona\TSystems\TSystemsPadroService;
        });
        

        //helpers
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename){
            require_once($filename);
        }


        
        if (file_exists(config_path('tsystems.php'))) {
            $this->mergeConfigFrom(config_path('tsystems.php'), 'tsystems');
        } else {
            $this->mergeConfigFrom(__DIR__.'/Config/tsystems.php', 'tsystems');
        }
        
    }
}
