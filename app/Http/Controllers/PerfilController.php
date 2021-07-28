<?php

namespace App\Http\Controllers;

use App\Perfil;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{


     /**
     * Display the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
        //
        return view('perfiles.show',compact('perfil'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {
        //
        return view('perfiles.edit', compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {

        // dd($request['imagen']);
        //Validar entrada de datos

        $data = request()->validate([
            'nombre'=>'required',
            'url'=>'required',
            'biografia'=>'required'
        ]);

        //Si el usuario sube una imagen
        if($request['imagen']){
            //Obtener Ruta de la imagen
            $ruta_imagen=$request['imagen']->store('upload-perfiles','public');

            //resize de la imagen
    
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(600,600);
            $img->save();
            //Crear un arreglo de imagen
            $array_imagen=['imagen' => $ruta_imagen];
        }
        //Asignar nombre y URl
        auth()->user()->url = $data['url'];
        auth()->user()->name = $data['nombre'];
        auth()->user()->save();

        //Eliminar url y name de data
        unset($data['url']);
        unset($data['nombre']);

        //asignar biografia e imagen
        auth()->user()->perfil()->update(array_merge($data,$array_imagen ?? [])
        );
        //guardar info

        //redireccionar
        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perfil $perfil)
    {
        //
    }
}
