<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PageAController;
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
Route::get('/', [RegisterController::class, 'create'])->name('register');
Route::post('/', [RegisterController::class, 'store'])->name('registration.store');


Route::get('/link/{id}', [RegisterController::class, 'showLink'])
	->middleware('auth')
	->name('registration.link');

Route::get('/game-pageA/{link}', [PageAController::class, 'show'])
	->middleware('auth')
	->name('pages.pageA');

//Route::get('/game-pageA/{link}', [GameController::class, 'show'])
//	->middleware('auth')
//	->name('pages.game');