<?php

namespace App\Http\Controllers;

use App\Receta;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    //
     function index()
    {
        //Obtener las recetas mas nuevas
        //take funciona como el limit
        $nuevas = Receta::latest()->take(5)->get();
        // return $nuevas;
        return view('inicio.index', compact('nuevas'));
    }
}
