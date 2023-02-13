<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StudiesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function() {
    return response()->json(["Welcome" => "API Laravel 9"], 200);
});

Route::resource('/products', ProductController::class);
Route::resource('/products', ProductController::class)->except(['create', 'edit']);

Route::resource('/studies', StudiesController::class);
Route::resource('/studies', StudiesController::class)->except(['create', 'edit']);

Route::fallback(function () {
    return response()->json(["Error" => "No encontrado"], 404);
});