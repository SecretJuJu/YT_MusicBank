<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\Auth\GoogleController;

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
    return view('home');
});




Auth::routes();

Route::get('/user_info',[App\Http\Controllers\UserInfoController::class,'show'])->name('user_logs.show');
Route::post('/user_info',[App\Http\Controllers\UserInfoController::class,'store'])->name('user_logs.show');

Route::get("/auth/policy",function (){
    return view('auth.policy');
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);