<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppEjemplo extends Controller
{
    public function mostrarInformacion()
    {
        $modulo = 'DWES';
        $ciclo = 'DAW';

        $horas = [
            "lunes" => 1,
            "miercoles" => 2,
            "jueves" => 3
        ];

        // return view('mostrarInformacion', array('modulo' => $modulo, 'ciclo' => $ciclo));
        // return view('mostrarInformacion', ["modulo" => $modulo, "ciclo" => $ciclo]);
        // return view('mostrarInformacion')->with(["modulo" => $modulo, "ciclo" => $ciclo]);

        // return view('asignaturas.mostrarInformacion', compact('modulo', 'ciclo', 'horas'));
        return view('asignaturas.page', compact('modulo', 'ciclo', 'horas'));
    }
}
