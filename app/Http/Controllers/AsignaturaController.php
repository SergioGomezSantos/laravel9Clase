<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo "Index";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('asignaturas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        // $nombre = $request('nombre');
        // $nombre = $request->get('nombre');

        // $nombre = $request->input('nombre');
        // $curso = $request->input('curso');
        // $ciclo = $request->input('ciclo');
        // $comentario = $request->input('comentario');

        // $datos = $request->all();

        // $datos = $request->only('nombre', 'ciclo');

        // $datos = $request->except('_token');

        // if ($request->has('nuevoCampo')) {

        //     dd($request->input('nuevoCampo'));

        // } else {
            
        //     dd("No existe nuevoCampo");
        // }

        $datos = $request->validate(
            [
                'nombre' => 'required|max:20',
                'curso' => 'required|numeric|min:1|max:2',
                'ciclo' => 'required|size:3|regex:/DA[M,W]/',
                'comentario' => ''
            ],
            [
                'nombre.required' => 'Nombre es obligatorio',
                'nombre.max' => 'Nombre no puede tener más de 20 caracteres',

                'curso.required' => 'Curso es obligatorio',
                'curso.numeric' => 'Curso tiene que ser un número',
                'curso.min' => 'Curso tiene que estar entre 1 y 2',
                'curso.max' => 'Curso tiene que estar entre 1 y 2',

                'ciclo.required' => 'Ciclo es obligatorio',
                'ciclo.size' => 'Ciclo tiene que ser DAM o DAW',
                'ciclo.regex' => 'Ciclo tiene que ser DAM o DAW',
            ]
        );

        dd($datos, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
