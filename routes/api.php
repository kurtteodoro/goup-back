<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\GithubController;
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

Route::prefix('user')->group(function() {

    Route::post('login', [UserController::class, 'login'] )->name('login');
    Route::post('register', [UserController::class, 'store'] )->name('register');
    
    Route::middleware('auth:api')->group(function() {
        Route::get('buscar/perfil/github', [GithubController::class, 'buscar'] )->name('buscar.perfil');
        Route::post('add/favorite', [GithubController::class, 'addFavorite'] )->name('add.favorite');
        Route::post('remove/favorite', [GithubController::class, 'removeFavorite'] )->name('add.favorite');
        Route::get('search/favorite', [GithubController::class, 'searchFavorites'] )->name('search.favorite');
    });

});
