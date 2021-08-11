<?php

namespace App\Http\Controllers;

use App\Receta;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function update(Request $request, Receta $receta)
    {
        //Almacena los likes de un usuario a una receta
        // toogle si ya esta en la base lo quita y si no lo afgrega
        return auth()->user()->meGusta()->toggle($receta);
    }

   
}
