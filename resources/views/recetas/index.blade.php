@extends('layouts.app')


@section('botones')
{{-- {{Auth::user()}} --}}
   @include('ui.navegacion')
@endsection

@section('content')
    <h2 class="text-center mb-5">Administra tus recetas</h2>
    {{-- {{$recetas}} --}}
    <div class="col-md-10 mx-auto bg-white p-3">
        <table class="table">
            <thead class="bg-primary text-light">
                <tr>
                    <th scole="col">Título</th>
                    <th scole="col">Categoría</th>
                    <th scole="col">Acciones</th>
                </tr>

            </thead>
            <tbody>
                @foreach($recetas as $receta)                  
                <tr>
                    <td>{{$receta->titulo}}</td>
                    <td>{{$receta->categoria->nombre}}</td>
                    <td>
                        {{-- Una forma de eliminar --}}
                        {{-- <form action="{{route('recetas.destroy',['receta' => $receta->id])}}" method="POST">
                            @csrf
                            @method('DELETE')

                            <input type="submit" class="btn btn-danger mr-1 d-block w-100 mb-2" value="Eliminar &times;">
                        </form> --}}

                        <eliminar-receta receta-id={{$receta->id}}>
                            
                        </eliminar-receta>


                        <a href="{{route('recetas.edit',['receta'=> $receta->id])}}" class="btn btn-dark d-block mb-2">Editar</a>
                        {{-- una forma de direccionar --}}
                        {{-- <a href="{{action('RecetaController@show',['receta'=> $receta->id])}}" class="btn btn-success mr-1">Ver</a> --}}
                        {{-- Otra forma de redireccionar --}}
                        <a href="{{route('recetas.show',['receta'=> $receta->id])}}" class="btn btn-success d-block">Ver</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-12 mt-4 justify-content-center d-flex">
        {{$recetas->links()}}
        </div>
        <h2 class="text-center my-5">Recetas que te gustan</h2>
        <div class="col-md-10 mx-auto bg-white p-3">
            @if(count($usuario->meGusta)>0)
                
            <ul>
                @foreach($usuario->meGusta as $receta)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                    <p> {{$receta->titulo}}</p> 
                    <a class="btn btn-outline-success text-uppercase font-weight-bold" href="{{route('recetas.show',['receta' => $receta->id])}}">Ver</a>
                    </li>
                    
                @endforeach
          </ul>
            @else
            <p class="text-center">Aún no tienes recetas guardadas 
            <small>Dale me gusta a las recetas y aparecerán aqui </small>
            </p>
            @endif
        </div>
 
    </div>

@endsection
