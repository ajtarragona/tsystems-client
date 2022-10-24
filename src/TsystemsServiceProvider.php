<?php

namespace Ajtarragona\Tsystems;

use Illuminate\Support\ServiceProvider;

class TsystemsServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        //vistas
        $this->loadViewsFrom(__DIR__.'/resources/views', 'tsystems');
        

        
        //cargo rutas
        $this->loadRoutesFrom(__DIR__.'/routes.php');


        //publico configuracion         
        $this->publishes([
            __DIR__.'/Config/tsystems.php' => config_path('tsystems.php'),
            __DIR__.'/Config/tsystems-database.php' => config_path('tsystems-database.php'),

        ], 'ajtarragona-tsystems-config');

        

        
        


       
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       	//registro middleware
        $this->app['router']->aliasMiddleware('tsystems-backend', \Ajtarragona\Tsystems\Middlewares\TsystemsBackend::class);

        //defino facades
        $this->app->bind('tsystems-tercers', function(){
            return new \Ajtarragona\Tsystems\Services\TsystemsTercersService;
        });
        $this->app->bind('tsystems-vialer', function(){
            return new \Ajtarragona\Tsystems\Services\TsystemsVialerService;
        });
        $this->app->bind('tsystems-padro', function(){
            return new \Ajtarragona\Tsystems\Services\TsystemsPadroService;
        });
        
        $this->app->bind('tsystems-expedients', function(){
            return new \Ajtarragona\Tsystems\Services\TsystemsExpedientsService;
        });
        
        $this->app->bind('tsystems-rdpost', function(){
            return new \Ajtarragona\Tsystems\Services\TsystemsRdpostService;
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

        if (file_exists(config_path('tsystems-database.php'))) {
            $this->mergeConfigFrom(config_path('tsystems-database.php'), 'database.connections');
        } else {
            $this->mergeConfigFrom(__DIR__.'/Config/tsystems-database.php', 'database.connections');
        }
        
    }
}
