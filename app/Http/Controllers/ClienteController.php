<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Exception;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', ['clientes' => $clientes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "DNI" => "required|regex:/^[0-9]{8}[A-Z]$/i",
            "Nombre" => "required|max:100",
            "Apellidos" => "required|max:200",
            "Telefono" => ["required", "regex:/(\+34|34)?[ -]*(6|8|9)[ -]*([0-9][ -]*){8}$/"],
            "Telefono" => "required",
            "Email" => "required|email"
        ], [
            "DNI.required" => "<b>DNI</b> es obligatorio",
            "DNI.regex" => "<b>DNI</b> tiene que ser 8 números y 1 letra",
            "Nombre.required" => "<b>Nombre</b> es obligatorio",
            "Nombre.max" => "<b>Nombre</b> no puede tener más de 100 caractéres",
            "Apellidos.required" => "<b>Apellidos</b> es obligatorio",
            "Apellidos.max" => "<b>Apellidos</b> no puede tener más de 200 caractéres",
            "Telefono.required" => "<b>Telefono</b> es obligatorio",
            "Telefono.regex" => "<b>Telefono</b> tiene que ser válido",
            "Email.required" => "<b>Email</b> es obligatorio",
            "Email.email" => "<b>Email</b> tiene que ser valido"
        ]);

        try {

            Cliente::create($request->all());
            return redirect()->route("clientes.index")->with('result', 'Cliente Creado');

        } catch (Exception $e) {

            return redirect()->route("clientes.index")->with('error', 'Error al Crear. ' . $e->getMessage());
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
        $cliente = Cliente::find($id);

        if ($cliente) {

            return view('clientes.show', ['cliente' => $cliente]);

        } else {

            return redirect()->route("clientes.index")->with('error', 'Cliente no Encontrado');
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
        $cliente = Cliente::find($id);
        
        if ($cliente) {

            return view('clientes.edit', ['cliente' => $cliente]);

        } else {

            return redirect()->route("clientes.index")->with('error', 'Cliente no Encontrado');
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
            "DNI" => "required|regex:/^[0-9]{8}[A-Z]$/i",
            "Nombre" => "required|max:100",
            "Apellidos" => "required|max:200",
            "Telefono" => ["required", "regex:/(\+34|34)?[ -]*(6|8|9)[ -]*([0-9][ -]*){8}$/"],
            "Email" => "required|email"
        ], [
            "DNI.required" => "<b>DNI</b> es obligatorio",
            "DNI.regex" => "<b>DNI</b> tiene que ser 8 números y 1 letra",
            "Nombre.required" => "<b>Nombre</b> es obligatorio",
            "Nombre.max" => "<b>Nombre</b> no puede tener más de 100 caractéres",
            "Apellidos.required" => "<b>Apellidos</b> es obligatorio",
            "Apellidos.max" => "<b>Apellidos</b> no puede tener más de 200 caractéres",
            "Telefono.required" => "<b>Telefono</b> es obligatorio",
            "Telefono.regex" => "<b>Telefono</b> tiene que ser válido",
            "Email.required" => "<b>Email</b> es obligatorio",
            "Email.email" => "<b>Email</b> tiene que ser valido"
        ]);

        $cliente = Cliente::find($id);
        $cliente->DNI = $request->input('DNI');
        $cliente->Nombre = $request->input('Nombre');
        $cliente->Apellidos = $request->input('Apellidos');
        $cliente->Telefono = $request->input('Telefono');
        $cliente->Email = $request->input('Email');
        
        try {

            $cliente->update();
            return redirect()->route("clientes.show", ['cliente' => $cliente])->with('result', 'Cliente Editado');

        } catch (Exception $e) {

            return redirect()->route("clientes.show", ['cliente' => $cliente])->with('error', 'Error al Editar. ' . $e->getMessage());
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
        $cliente = Cliente::find($id);

        if ($cliente) {

            try {

                $cliente->delete();
                return redirect()->route("clientes.index")->with('result', 'Cliente Eliminado');
    
            } catch (Exception $e) {
    
                return redirect()->route("clientes.index")->with('error', 'Error al Eliminar. ' . $e->getMessage());
            }
            
        } else {

            return redirect()->route("clientes.index")->with('error', 'Cliente no Encontrado');
        }
    }
}
