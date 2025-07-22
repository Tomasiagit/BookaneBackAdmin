<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\PacoteController;
use App\Http\Controllers\PagamentoController;
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
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);  
});
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

Route::get('/livros',[LivroController::class, 'index']);
Route::post('/livros',[LivroController::class,'store']);
Route::get('/livros/{id}',[LivroController::class,'show']);
Route::post('/livros/{id}',[LivroController::class, 'update']);
Route::get('/livros/classe/{classe_id}',[LivroController::class,'livrosPorClasse']);
Route::delete('/livros/{id}',[LivroController::class, 'destroy']);

Route::get('/pagamentos', [PagamentoController::class, 'index']);
Route::post('/pagamentos', [PagamentoController::class, 'store']);
Route::post('/pagamentos/{id}', [PagamentoController::class, 'update']);
Route::get('/pagamentos/estado/{userid}',[PagamentoController::class, 'verify_user_payment']);
Route::get('/pagamentos/{id}',[PagamentoController::class, 'show']);
Route::delete('/pagamentos/{id}',[PagamentoController::class, 'destroy']);

Route::get('/disciplinas', [DisciplinaController::class, 'index']);
Route::get ('/classes', [ClasseController::class, 'index']);