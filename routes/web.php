<?php

use App\Http\Controllers\StudiesController;
use Illuminate\Support\Facades\Route;

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

Route::get('/prueba/{id?}', function ($id = 'default') {
    echo "Id: $id";
});

Route::get('studies', [StudiesController::class, 'index']);
Route::get('studies/create', [StudiesController::class, 'create']);
Route::get('studies/{id}', [StudiesController::class, 'show']);
Route::get('studies/{id}/edit', [StudiesController::class, 'edit']);