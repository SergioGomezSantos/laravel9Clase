<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\MockObject\Builder\Stub;
use Exception;

class StudiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status' => 'OK', 'data' => Study::all()], 200);
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
                "code" => "required|max:6",
                "name" => "required|max:100",
                "family" => "required|in:IFC301",
                "level" => "required|in:GM,GS"
            ], [
                "code.required" => "Code es obligatorio",
                "code.max" => "Code no puede tener más de 6 caracteres",
                "name.required" => "Name es obligatorio",
                "name.max" => "Name no puede tener más de 100 caracteres",
                "family.required" => "Family es obligatorio",
                "family.in" => "Family tiene que ser IFC301",
                "level.required" => "Level es obligatorio",
                "level.in" => "Level tiene que ser GM / GS"
            ]
        );

        if ($validated->fails()) {
            return response()->json(["status" => "error", "data" => $validated->errors()], 422);
        }

        $newStudy = Study::create($request->all());
        return response()->json(["status" => "ok", "data" => $newStudy], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $study = Study::find($id);

        if ($study) {

            return response()->json(['status' => 'ok', 'data' => $study], 200);

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
        $study = Study::find($id);

        if ($study) {

            $validated = Validator::make(
                $request->all(), 
                [
                    "code" => "required|max:6",
                    "name" => "required|string|max:100",
                    "family" => "required|in:IFC301",
                    "level" => "required|in:GM,GS"
                ], [
                    "code.required" => "Code es obligatorio",
                    "code.max" => "Code no puede tener más de 6 caracteres",
                    "name.required" => "Name es obligatorio",
                    "name.max" => "Name no puede tener más de 100 caracteres",
                    "family.required" => "Family es obligatorio",
                    "family.in" => "Family tiene que ser IFC301",
                    "level.required" => "Level es obligatorio",
                    "level.in" => "Level tiene que ser GM / GS"
                ]
            );

            if ($validated->fails()) {
                return response()->json(["status" => "error", "data" => $validated->errors()], 422);
            }
            
            $study->fill($request->all());

            try {

                $study->update();
                return response()->json(["status" => "ok", "data" => $study], 200);
    
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
        $study = Study::find($id);

        if ($study) {

            try {

                $study->delete();
                return response()->json(["status" => "ok"], 204);
    
            } catch (Exception $e) {
    
                return response()->json(["status" => "error", "data" => $e->getMessage()], 409);
            }

        } else {

            return response()->json(['status' => "error", 'data' => 'Not Found'], 404);
        }
    }
}
