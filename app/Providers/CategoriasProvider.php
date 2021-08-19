<?php

namespace App\Providers;
use View;
use App\CategoriaReceta;
use Illuminate\Support\ServiceProvider;

class CategoriasProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
        // regisrer ejecuta todo cuando la aplicaion aun no inicia por eso no puedo poner evenlisteners
        // Y cuando no uso nada de lo que laravel requiere
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    // Boot ejecuta todo cuando la aplicaion ya esta lista
    public function boot()
    {
        //
        View::composer('*',function($view){

            $categorias=CategoriaReceta::all();
            $view->with('categorias',$categorias);
        });
    }
}
