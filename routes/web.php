<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PartnerController;
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
})->name('home');

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'checkCredentials'])->name('login.checkCredentials');
Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');

//pivote
Route::post('/partners/storePivot/{id}' , [PartnerController::class, 'storePivot'])->name('partners.storePivot');
Route::get('/partners/{partner_id}/{pivot_id}/edit' , [PartnerController::class, 'editPivot'])->name('partners.editPivot');
Route::put('/partners/{partner_id}/{pivot_id}/update' , [PartnerController::class, 'updatePivot'])->name('partners.updatePivot');
Route::delete('/partners/{id}/{pivot_id}' , [PartnerController::class, 'destroyPivot'])->name('partners.destroyPivot');

//partner
Route::resource('partners', PartnerController::class);