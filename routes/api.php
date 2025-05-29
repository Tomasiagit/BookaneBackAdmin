<?php

use App\Http\Controllers\PacoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; 

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
//Route::apiResource('users', UserController::class);
Route::get('/users',[UserController::class, 'index']);
Route::post('/users',[UserController::class,'store']);
Route::get('/users/{id}',[UserController::class,'show']);
Route::post('/users/{id}',[UserController::class, 'update']);
Route::delete('/users/{id}',[UserController::class, 'destroy']);

Route::get('/pacotes',[PacoteController::class, 'index']);
Route::post('/pacotes',[PacoteController::class,'store']);
Route::get('/pacotes/{id}',[PacoteController::class,'show']);
Route::post('/pacotes/{id}',[PacoteController::class, 'update']);
Route::delete('/pacotes/{id}',[PacoteController::class, 'destroy']);

