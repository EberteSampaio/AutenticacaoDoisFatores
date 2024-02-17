<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
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
Route::get('/', function (){
    return to_route('login.index');
});

Route::get('/login',[LoginController::class,'formLogin'])
    ->name('login.index');
Route::post('/login-validate',[LoginController::class,'loginValidate'])
    ->name('login.validate');
Route::get('/confirm-form',[LoginController::class,'formCode'])
    ->name('login.code');

Route::post('/confirm-code',[LoginController::class,'confirmCode'])
    ->name('login.code-validate');

Route::get('/register',[RegisterController::class,'formRegister'])
    ->name('register.index');

Route::post('/register-validate',[RegisterController::class,'createUser'])
    ->name('register.create');

Route::get('/home',[\App\Http\Controllers\HomeController::class,'index'])
    ->name('home.index');
