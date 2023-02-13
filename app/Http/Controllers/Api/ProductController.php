<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status' => 'OK', 'data' => Product::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(), 
            [
                "nombre" => "required|max:100",
                "descripcion" => "required",
                "precio" => "required|numeric|gt:0"
            ]
        );

        if ($validated->fails()) {
            return response()->json(["status" => "error", "data" => $validated->errors()], 422);
        }

        $newProduct = Product::create($request->all());
        return response()->json(["status" => "ok", "data" => $newProduct], 201);
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

        if ($product) {

            return response()->json(['status' => 'ok', 'data' => $product], 200);

        } else {

            return response()->json(['status' => 'error', 'data' => 'Not Found'], 404);
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
        $product = Product::find($id);

        if ($product) {

            $validated = Validator::make(
                $request->all(), 
                [
                    "nombre" => "required|max:100",
                    "descripcion" => "required",
                    "precio" => "required|numeric|gt:0"
                ]
            );

            if ($validated->fails()) {
                return response()->json(["status" => "error", "data" => $validated->errors()], 422);
            }
            
            $product->fill($request->all());

            try {

                $product->update();
                return response()->json(["status" => "ok", "data" => $product], 200);
    
            } catch (Exception $e) {
    
                return response()->json(["status" => "error", "data" => $e->getMessage()], 409);
            }

        } else {

            return response()->json(['status' => "error", 'data' => 'Not Found'], 404);
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

        if ($product) {

            try {

                $product->delete();
                return response()->json(["status" => "ok"], 204);
    
            } catch (Exception $e) {
    
                return response()->json(["status" => "error", "data" => $e->getMessage()], 409);
            }

        } else {

            return response()->json(['status' => "error", 'data' => 'Not Found'], 404);
        }
    }
}
