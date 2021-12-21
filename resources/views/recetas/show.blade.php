@extends('layouts.app')

@section('content')
    {{-- <h1>{{$receta}}</h1> --}}

    <article class="contenido-receta bg-white shadow p-4">
        <h1 class="text-center mb-4 " >{{ ucwords($receta->titulo)}}</h1>
        <div class="imagen-receta">
            <img src="{{asset('storage').'/'.$receta->imagen}}" alt="" class="w-100">
        </div>
        <div class="receta-meta mt-4">
            <p>
                <span class="font-weight-bold text-primary">Escrito en:</span>
                <a class="text-dark" href="{{route('categorias.show',['categoriaReceta'=>$receta->categoria->id])}}">
                    {{$receta->categoria->nombre}}
                </a>
                
            </p>
            <p>
                <span class="font-weight-bold text-primary">Autor</span>
                <a class="text-dark" href="{{route('perfiles.show',['perfil'=>$receta->autor->id])}}">
                    {{$receta->autor->name}}</a>
                {{-- Mostrar el Usuario --}}
                
            </p>
            <p>
                <span class="font-weight-bold text-primary">Fecha</span>
                @php
                    $fecha = $receta->created_at
                @endphp
                <fecha-receta fecha="{{$fecha}}"></fecha-receta>
                
            </p>
            
            
            <div class="ingredientes">
                <h2 class="my-3 text-primary">Ingredientes</h2>
                {!!$receta->ingredientes!!} {{-- De esta forma evitamos que se muestre el codigo html --}}
                
            </div>
            <div class="preparacion">
                <h2 class="my-3 text-primary">Preparacion</h2>
                {!!$receta->preparacion!!} {{-- De esta forma evitamos que se muestre el codigo html --}}
                
            </div>
            <div class="justify-content-center row text-center">
                <like-button
                receta-id="{{$receta->id}}" 
                like="{{$like}}" 
                likes="{{$likes}}"
                ></like-button >
            </div>
            
           
        </div>
    </article>
@endsection