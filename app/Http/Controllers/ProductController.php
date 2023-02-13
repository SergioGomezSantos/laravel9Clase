<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        session(["visitasPares" => 0]);
        $this->middleware("auth");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize("viewAny", Product::class);
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize("create", Product::class);
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->authorize("create", Product::class);

        $request->validate([
            "nombre" => "required|max:100",
            "descripcion" => "required",
            "precio" => "required|numeric|gt:0",
        ], [
            "nombre.required" => "<b>Nombre</b> es obligatorio",
            "nombre.max" => "<b>Nombre</b> no puede tener más de 100 caractéres",
            "descripcion.required" => "<b>Descripcion</b> es obligatoria",
            "precio.required" => "<b>Precio</b> es obligatorio",
            "precio.numeric" => "<b>Precio</b> tiene que ser un número",
            "precio.gt" => "<b>Precio</b> tiene que ser mayor que 0"
        ]);

        $this->authorize("create", Product::class);

        try {

            Product::create($request->all());
            return redirect()->route("products.index")->with('result', 'Producto Creado');

        } catch (Exception $e) {

            return redirect()->route("products.index")->with('error', 'Error al Crear. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $this->authorize("view", $product);

        if ($product) {

            if ($product->id % 2 === 0) {

                session()->increment("visitasPares");
                session()->flash('color', 'Verde');
                return view('products.show', ['product' => $product]);

            } else {

                session(["visitasPares" => 0]);
                session()->flash('color', 'Rojo');
                return view('products.show', ['product' => $product]);
            }

        } else {

            return redirect()->route("products.index")->with('error', 'Producto no Encontrado');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $this->authorize("update", Product::class);
        
        if ($product) {

            return view('products.edit', ['product' => $product]);

        } else {

            return redirect()->route("products.index")->with('error', 'Producto no Encontrado');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "nombre" => "required|max:100",
            "descripcion" => "required",
            "precio" => "required|numeric|gt:0",
        ], [
            "nombre.required" => "<b>Nombre</b> es obligatorio",
            "nombre.max" => "<b>Nombre</b> no puede tener más de 100 caractéres",
            "descripcion.required" => "<b>Descripcion</b> es obligatoria",
            "precio.required" => "<b>Precio</b> es obligatorio",
            "precio.numeric" => "<b>Precio</b> tiene que ser un número",
            "precio.gt" => "<b>Precio</b> tiene que ser mayor que 0"
        ]);

        $product = Product::find($id);
        $this->authorize("update", $product);

        $product->nombre = $request->input('nombre');
        $product->descripcion = $request->input('descripcion');
        $product->precio = $request->input('precio');
        
        try {

            $product->update();
            return redirect()->route("products.show", ['product' => $product])->with('result', 'Producto Editado');

        } catch (Exception $e) {

            return redirect()->route("products.show", ['product' => $product])->with('error', 'Error al Editar. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $this->authorize("delete", $product);

        if ($product) {

            try {

                $product->delete();
                return redirect()->route("products.index")->with('result', 'Producto Eliminado');
    
            } catch (Exception $e) {
    
                return redirect()->route("products.index")->with('error', 'Error al Eliminar. ' . $e->getMessage());
            }
            
        } else {

            return redirect()->route("products.index")->with('error', 'Producto no Encontrado');
        }
    }
}
