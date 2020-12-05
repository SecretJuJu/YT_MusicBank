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

Route::get('/',App\Http\Controllers\homeController::class)->name('home');




Auth::routes();
Route::get("/auth/policy",function (){
    return view('auth.policy');
});
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// UserInfoController
Route::get('/myDownloads',[App\Http\Controllers\UserInfoController::class,'show'])->name('myDownloads.show');
Route::post('/logging',[App\Http\Controllers\UserInfoController::class,'store'])->name('myDownloads.store');

// youtubeController
Route::get('/search',[App\Http\Controllers\YoutubeController::class,'search'])->name('youtube.search');

Route::post('/download',[App\Http\Controllers\YoutubeController::class,'download'])->name('youtube.downloadLogic');
// for logging test
//  Route::post('/download',[App\Http\Controllers\YoutubeController::class,'download'])->name('youtube.download');


// CheckFile
Route::get('/check',[App\Http\Controllers\FilesController::class,'check'])->name('file.check');