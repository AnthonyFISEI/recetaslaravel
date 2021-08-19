@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="titulo-categoria text-uppercase mt-5 mb-4">
            Resultados Búsqueda: {{$busqueda}}
        </h2>
        @if(count($recetas)!=0)
        <div class="row">
            @foreach($recetas as $receta)
                @include('ui.receta')
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-5">
            {{$recetas->links()}}
        </div>
        @else
        <h2 class="text-primary">Ups.. No existen resultados para tu búsqueda</h2>
        @endif
        
    </div>
    
@endsection