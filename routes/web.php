<?php

use App\Http\Controllers\AppEjemplo;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\StudiesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductoController;
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



// Route::get('studies', [StudiesController::class, 'index']);
// Route::get('studies/create', [StudiesController::class, 'create']);
Route::get('studies/{id}', [StudiesController::class, 'show'])->where('id', '[0-9]+');
// Route::get('studies/{id}/edit', [StudiesController::class, 'edit']);

// Route::post('studies', [StudiesController::class, 'store']);
// Route::put('studies/{id}', [StudiesController::class, 'put']);
// Route::delete('studies/{id}', [StudiesController::class, 'delete']);

// Route::resource('/studies', StudiesController::class);


Route::get('/prueba/{id?}', function ($id = 'default') {
    echo "Id: $id";
});

Route::get('prueba2/{name}', [PruebaController::class, 'saludoCompleto']);


Route::get('/contacto', function () {
    echo "<a href='" . route('contacto') . "'>Contactar</a><br>";
    echo "<a href='" . route('infoasig') . "'>Información Asignatura</a><br>";
});

Route::get('/contactar-con-instituto', function () {
    return "Contactar";
})->name('contacto');

Route::get('/informacion-asignatura', [AppEjemplo::class, 'mostrarInformacion'])->name('infoasig');

Route::resource('/asignaturas', AsignaturaController::class);



Route::get('/videoclub', [HomeController::class, 'getHome']);
Route::get('/videoclub/catalog', [CatalogController::class, 'getIndex']);
Route::get('/videoclub/catalog/create', [CatalogController::class, 'getCreate']);
Route::get('/videoclub/catalog/show/{id?}', [CatalogController::class, 'getShow']);
Route::get('/videoclub/catalog/edit/{id?}', [CatalogController::class, 'getEdit']);

Route::get('/videoclub/login', function () {
    return view('videoclub.auth.login');
});

Route::post('/videoclub/logout', function () {
    return 'logout';
});



Route::resource('/products', ProductController::class);
Route::resource('/clientes', ClienteController::class);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('productos', ProductoController::class);