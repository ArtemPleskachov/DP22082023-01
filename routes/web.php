<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//
//Route::get('/', function () {
//    return view('registration.form');
//});

Route::get('/', [RegisterController::class, 'create'])->name('register');
Route::post('/', [RegisterController::class, 'store'])->name('registration.store');

Route::view('/link', 'registration.link')->middleware('auth')->name('registration.link');
