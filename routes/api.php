<?php

use Illuminate\Http\Request;

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
Route::middleware('api')->namespace('Auth')->prefix('auth')->group(function(){
  Route::post('register', 'AuthController@register');
  Route::post('login', 'AuthController@login');
  Route::post('logout', 'AuthController@logout');
  Route::post('refresh', 'AuthController@refresh');
  Route::post('me', 'AuthController@me');
});
Route::middleware('jwt.auth')->group(function() {
  Route::prefix('movies')->group(function(){
    Route::apiResource('/{movie}/reviews', 'ReviewController');
  });
});

Route::middleware(['jwt.auth', 'can:view-movies'])->group(function() {
  Route::apiResource('movies', 'MovieController')->only([
    'index',
    'show',
  ]);

  Route::apiResource('actors', 'ActorController')->only([
    'index',
    'show',
  ]);

  Route::apiResource('directors', 'DirectorController')->only([
    'index',
    'show',
  ]);
});

Route::middleware(['jwt.auth', 'can:manage-movies'])->group(function() {
  Route::apiResource('movies', 'MovieController')->only([
    'store',
    'update',
    'destroy',
  ]);

  Route::apiResource('actors', 'ActorController')->only([
    'store',
    'update',
    'destroy',
  ]);

  Route::apiResource('directors', 'DirectorController')->only([
    'store',
    'update',
    'destroy',
  ]);
});

Route::middleware(['jwt.auth', 'can:manage-roles'])->group(function() {
  Route::post('/admin/assign', 'AdminController@assign');
  Route::post('/admin/retract', 'AdminController@retract');
});
