<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    //
     function index()
    {

        // Mostrar recetas por cantidad de votos
        // primera forma

        // $votadas = Receta::has('likes','>',1)->get();

        // Segunda forma

        $votadas = Receta::withCount('likes')->orderBy('likes_count','desc')->take(3)->get();




        //Obtener las recetas mas nuevas
        //take funciona como el limit
        $nuevas = Receta::latest()->take(5)->get();
        // return $nuevas;


        // Recetas por categoria
        // una forma
        // $mexicana=Receta::where('categoria_id',1)->get();
        // return $mexicana;
        // otra forma

        // Obterner primero todas las categorias
        $categorias=CategoriaReceta::all();
        // return $categorias;

        // Agrupar las recetas por categoría

        $recetas= [];
        foreach ($categorias as $categoria) {
            # code...
            $recetas[Str::slug($categoria->nombre)][]=Receta::where('categoria_id',$categoria->id)->take(3)->get();
        }


    //   return $recetas;

        return view('inicio.index', compact('nuevas','recetas','votadas'));
    }
}
