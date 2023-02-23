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

        if (session('worker')) {
            return redirect()->route("home");
        }

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
        $request->validate([
            "name" => "required",
            "password" => "required"
        ], [
            "name.required" => "Nombre es obligatorio",
            "password.required" => "Contraseña es obligatoria"
        ]);

        try {

            $worker = Worker::where('name', $request->input('name'))->first();

            if ($worker) {

                if ($worker->password == $request->input('password')) {
    
                    session(['worker' => [
                        "name" => $worker->name, 
                        "role" => $worker->role,
                        "center_id" => $worker->center_id
                        ]
                    ]);
                    return redirect()->route("partners.index")->with('result', 'Inicio de Sesión Correcto');
                }

            } 

            return redirect()->route("login.index")->with('error', 'Credenciales Incorrectos');

        } catch(Exception $e) {

            return redirect()->route("login.index")->with('error', 'Error al Loggear. ' . $e->getMessage());
        }
    }

    /**
     * Logout from Session
     *
     * @return \Illuminate\Http\Response
     */
    public function logout() {

        session()->forget('worker');
        return redirect()->route("home");
    }
}
