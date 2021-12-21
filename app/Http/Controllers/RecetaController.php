<?php

namespace App\Http\Controllers;

use App\Models\CategoriaReceta;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{
    

    public function __construct()
    {
        $this->middleware('auth',['except'=> ['show','search']]); //middleware para proteger las rutas
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Auth::user()->recetas->dd();
        // auth()->user()->recetas->dd();// Otra forma de hacerlo 

        //$recetas = auth()->user()->recetas;
       
       
        $usuario = auth()->user(); 

        //$meGusta = auth()->user()->meGusta;

        // Receta con paginacion(para hacer esto se utiliza el modelo)

        $recetas = Receta::where('user_id',$usuario->id)->paginate(10);

        //$usuario = auth()->user(); nos evitamos esto al poner el auth en el index
        return view('recetas.index')
        ->with('recetas',$recetas)
        ->with('usuario',$usuario);
        //->with('usuario',$usuario);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //DB::table('categoria_receta')->get()->pluck('nombre','id')->dd();

        

        // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre','id'); // Obtener las Categorias (Sin Modelo)

        $categorias = CategoriaReceta::all(['id','nombre']); // Con Modelo
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
        //Validacion
        $data = $request->validate([
            'titulo' =>'required|min:6',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'imagen' => 'required|image',
            'categoria' => 'required'

        ]);

        //Obtener la ruta de la imagen
        $ruta_imagen = $request['imagen']->store('upload-recetas','public');

        // Resize de la imagen(utilizando intervetion image)
        $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(1000,550);
        $img->save();

        //Almacenar en la bd (sin modelo)

        // DB::table('recetas')->insert([
        //     'titulo'=>$data['titulo'],
        //     'preparacion'=>$data['preparacion'],
        //     'ingredientes'=>$data['ingredientes'],
        //     'imagen'=> $ruta_imagen,
        //     'user_id' => Auth::user()->id,
        //     'categoria_id'=>$data['categoria']
            
        // ]);

        // Almacenar en la BD (con modelo)
        auth()->user()->recetas()->create([
            'titulo'=>$data['titulo'],
            'preparacion'=>$data['preparacion'],
            'ingredientes'=>$data['ingredientes'],
            'imagen'=> $ruta_imagen,
            'categoria_id'=>$data['categoria']

        ]);

        // Redireccionar
        return redirect()->action([RecetaController::class,'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {

        // Obtner si el usuario actual le gusta la receta

        $like = (auth()->user()) ? auth()->user()->meGusta->contains($receta->id) : false;

        // Pasa la cantidad de likes a la vista
        $likes = $receta->likes->count();

        
        // Algunos metodo para obtener una receta

        //$receta = Receta::findOrFail($receta); // En caso de que no exista una receta nos marca un error (Recuerda que hay que elimar la paralabra Receta), este es un metodo antiguo.
        return view('recetas.show', compact('receta','like','likes'));
        // return view('recetas.show')->with('receta',$receta)->with('like',$like)->with('likes',$likes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {

        $this->authorize('view',$receta);
        
        $categorias = CategoriaReceta::all(['id','nombre']);
        return view('recetas.edit')
        ->with('categorias',$categorias)
        ->with('receta',$receta);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {

        //Revisar el policy

        $this->authorize('update',$receta);
        // Validacion
        $data = $request->validate([
            'titulo' =>'required|min:6',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'categoria' => 'required'

        ]);

        // Agisnar los valores
        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];

        if(request('imagen')){
            //Obtener la ruta de la imagen
            $ruta_imagen = $request['imagen']->store('upload-recetas','public');

            // Resize de la imagen(utilizando intervetion image)
            $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(1000,550);
            $img->save();

            // asiganr al objeto
            $receta->imagen = $ruta_imagen;
        }

        $receta->save();
        //Redireccionar 

        return redirect()->action([RecetaController::class,'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        
        // ejecutar el Policy
        $this->authorize('delete',$receta);

        // Elimar la receta
        $receta->delete();

        return redirect()->action([RecetaController::class,'index']);
    }
    public function search(Request $request){
        $busqueda = $request['buscar'];
        // $busqueda = $request->get('buscar');// Otro metodo

        $recetas = Receta::where('titulo','like','%'. $busqueda . '%')->paginate(2);
        $recetas->appends(['buscar' =>$busqueda]);
        return view('busquedas.show',compact('recetas','busqueda'));
    }
}
