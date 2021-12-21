<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategoriaReceta;

class InicioController extends Controller
{
    public function index(){
        // Mostrar las recetas por cantidad de votos
        // $votadas = Receta::has('likes','>',1)->get(); // podemos hacer para un buscador
        $votadas = Receta::withCount('likes')->orderBy('likes_count','desc')->take(3)->get();

        //Obtener las recetas mas nuevas
        // $nuevas = Receta::orderBy('created_at','DESC')->get(); // Esto es lo mismo que el latest en forma descendente
        $nuevas = Receta::latest()->take(5)->get(); // oldest() nos trae lo mas viejo osea forma ascendente, podemos usar limit o take para poner un limite de cuantas recetas vamos a mostrar

        // Obtener todas las categorias

        $categorias = CategoriaReceta::all();

        

        // Agregupar las recetas por categoria

        $recetas = [];

        foreach($categorias as $categoria){
            $recetas[ Str::slug($categoria->nombre)][] = Receta::where('categoria_id', $categoria->id)->get();
        }
        

        return view('inicio.index',compact('nuevas','recetas','votadas'));
    }
}
