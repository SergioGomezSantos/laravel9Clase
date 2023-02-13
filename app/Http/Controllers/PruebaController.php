<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PruebaController extends Controller
{
    public function saludoCompleto($name) {
        return "Hola $name. Encantado de conocerle";
    }
}
