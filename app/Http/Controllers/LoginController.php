<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Exception;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display the login form
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Si ya existe una sesión
        if (session('worker')) {

            //Redirige a Socios
            return redirect()->route("partners.index")->with('error', 'Ya hay una Sesión Iniciada');
        }

        //Si no existe, devuelve la vista de login
        return view('login.index');
    }

    /**
     * Check the credentials from the login form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkCredentials(Request $request)
    {
        // Validación de los campos del formulario

        $request->validate([
            "name" => "required",
            "password" => "required"
        ], [
            "name.required" => "Nombre es obligatorio",
            "password.required" => "Contraseña es obligatoria"
        ]);

        try {

            // Busca en BD un trabajador con el nombre introducido (unique en BD)
            $worker = Worker::where('name', $request->input('name'))->first();

            // Si existe el trabajador
            if ($worker) {

                // Si la contraseña del trabajador coincide con la insertada en el formulario
                if ($worker->password == $request->input('password')) {
    
                    // Establer sesión con 3 datos que se usarán en los demás métodos
                    session(['worker' => [
                        "name" => $worker->name, 
                        "role" => $worker->role,
                        "center_id" => $worker->center_id
                        ]
                    ]);

                    // Redirect a Socios con la sesión iniciada
                    return redirect()->route("partners.index")->with('result', 'Inicio de Sesión Correcto');
                }

            } 

            return redirect()->route("login.index")->with('error', 'Credenciales Incorrectos');

        } catch(Exception $e) {

            // Si falla por error general, redirect al index con el error
            return redirect()->route("login.index")->with('error', 'Error al Loggear. ' . $e->getMessage());
        }
    }

    /**
     * Logout from Session
     *
     * @return \Illuminate\Http\Response
     */
    public function logout() {

        // Borrar la sesión y redirigir a home
        session()->forget('worker');
        return redirect()->route("home");
    }
}
