<?php

use App\Http\Controllers\AppEjemplo;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\StudiesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});