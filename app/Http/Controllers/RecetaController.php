<?php

namespace App\Http\Controllers;

use App\CategoriaReceta;
use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Symfony\Component\VarDumper\Cloner\Data;

class RecetaController extends Controller
{

    //Con esto habilito el middleware de autenticación
    public function __construct(){
        // Aqui le digo que para acceder a los metodos de este controlador el ususario debe estar autenticado
        // COn except le digo que metodo sera publico y no necesita autenticacion
        $this->middleware('auth',['except' => 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // auth()->user()->recetas->dd();
        // una forma
        // $usuario = auth()->user();
        // $recetas = auth()->user()->recetas;

        //Recetas con paginacion
        $usuario=auth()->user();
        // $meGusta=auth()->user()->meGusta;

        $recetas= Receta::where('user_id',$usuario->id)->paginate(10);

        return view('recetas.index')
        ->with('recetas',$recetas)
        ->with('usuario',$usuario);
        // continua esto con una forma
        // return view('recetas.index')->with('recetas',$recetas)->with('usuario',$usuario);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Metodo para consultar la tabla
        // DB::table('categoria_receta')->get()->pluck('nombre','id')->dd();

        //Obtener categorias sin modelo
        // $categorias =  DB::table('categoria_recetas')->get()->pluck('nombre','id');

                //Obtener categorias con modelo

        $categorias =  CategoriaReceta::all(['id','nombre']);
        return view('recetas.create')->with('categorias',$categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //la funcion store srive para gusrdar las imagenes en el servidor le digo la carpeta

        // dd($request['imagen']->store('upload-recetas','public'));

        //Validacion
        $data=$request->validate([
            'titulo'=>'required|min:6',
            'preparacion'=>'required',
            'ingredientes'=>'required',
            'imagen'=>'required|image',
            'categoria'=>'required',
        ]);

        //Obtener Ruta de la imagen
        $ruta_imagen=$request['imagen']->store('upload-recetas','public');

        //resize de la imagen

        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1200,550);
        $img->save();

        //Alamcenar en la BD(SIN MODELO)
        // DB::table('recetas')->insert([
        //     'titulo'=>$data['titulo'],
        //     'preparacion'=>$data['preparacion'],
        //     'ingredientes'=>$data['ingredientes'],
        //     'imagen'=>$ruta_imagen,
        //     'user_id'=>Auth::user()->id,
        //     'categoria_id'=>$data['categoria']
        // ]);
        // dd($request->all());

        // Almacenar en la BD CON MODELO


       auth()->user()->recetas()->create([
            'titulo'=>$data['titulo'],
            'preparacion'=>$data['preparacion'],
            'ingredientes'=>$data['ingredientes'],
            'imagen'=>$ruta_imagen,
            'categoria_id'=>$data['categoria']
       ]);

        //Redireccionar 
        return redirect()->action('RecetaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        // Obtener si el usuario actual le gusta la receta y esta autenticado

        $like = (auth()->user()) ? auth()->user()->meGusta->contains($receta->id) : false ;
        
           // OPasa la cantidad de likes a la vista

           $likes = $receta->likes->count();
        //Algunos metodos para obtener una receta


        return view('recetas.show',compact('receta','like','likes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {

        
        //Revisar el policy

        $this->authorize('view',$receta);
        //
        $categorias =  CategoriaReceta::all(['id','nombre']);
        return view('recetas.edit',compact('categorias','receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        //Revisar el policy

        $this->authorize('update',$receta);
        //Validacion
        $data=$request->validate([
            'titulo'=>'required|min:6',
            'preparacion'=>'required',
            'ingredientes'=>'required',
            'categoria'=>'required',
        ]);

        //Aginar valores

        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];


        // Si el ususario sube una imagen

        if(request('imagen')){
            
            //Obtener Ruta de la imagen
            $ruta_imagen=$request['imagen']->store('upload-recetas','public');

            //resize de la imagen

            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1200,550);
            $img->save();

            // Asignar al objeto
            $receta->imagen = $ruta_imagen;
        }

        $receta->save();

        // Redireccionar
        return redirect()->action('RecetaController@index');
        // return 'editando...';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {

        // return "Eliminando....";
        //Ejecutar el policy
        $this->authorize('delete',$receta);

        //eleiminar la receta

        $receta->delete();
        return redirect()->action('RecetaController@index');
    }
}
