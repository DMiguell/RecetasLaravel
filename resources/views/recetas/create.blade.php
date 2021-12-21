@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('botones')
<a href="{{route('recetas.index')}}" class="btn btn-outline-primary mr-2 text-uppercase font-weight-bold">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 icono" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
      </svg>
    Volver</a>
@endsection

@section('content')
    <h2 class="text-center mb-5">Crear Nueva Receta</h2>
    
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <form method="POST" action="{{route('recetas.store')}}" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="form-group">
                    <label for="titulo">Titulo Receta</label>
                    <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" id="titulo" placeholder="Titulo Receta" value="{{old('titulo')}}">
                    @error('titulo')
                        <span class="invalid-feedback d-block" role="alert"><strong>{{$message}}</strong></span>
                        
                    @enderror
                </div>
                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select 
                    name="categoria" 
                    id="categoria" 
                    class="form-control @error('categoria') is-invalid @enderror" 
                    >
                    <option value="">-- Seleccione --</option>
                    {{-- @foreach ($categorias as $id => $categoria)
                        <option
                        value="{{$id}}" 
                        {{old('categoria') == $id ? 'selected':''}}>{{$categoria}}</option>
                    @endforeach --}}
                    @foreach ($categorias as $categoria)
                        <option
                        value="{{$categoria->id}}" 
                        {{old('categoria') == $categoria->id ? 'selected':''}}>
                        {{$categoria->nombre}}
                    </option>
                    @endforeach
                        
                    </select>
                    @error('categoria')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{$message}}</strong></span>
                        
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="preparacion">Preparacion</label>
                    <input id="preparacion" type="hidden" name="preparacion" value="{{old('preparacion')}}">
                    <trix-editor input="preparacion" class="form-control @error('preparacion') is-invalid @enderror"></trix-editor>

                    @error('preparacion')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{$message}}</strong></span>
                        
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="ingredientes">Ingredientes</label>
                    <input id="ingredientes" type="hidden" name="ingredientes" value="{{old('ingredientes')}}">
                    <trix-editor input="ingredientes" class="form-control @error('ingredientes') is-invalid @enderror"></trix-editor>

                    @error('ingredientes')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{$message}}</strong></span>
                        
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="imagen">Elige la imagen</label>

                    <input 
                    type="file" 
                    id="imagen" 
                    class="form-control @error('ingredientes') is-invalid @enderror" 
                    name="imagen"> 
                    
                    @error('imagen')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{$message}}</strong></span>
                        
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Agregar">
                </div>
            </form>
        </div>
    </div>

@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
@endsection