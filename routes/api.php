<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'registrarse']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/mostrar', [AuthController::class, 'mostrar']);
Route::get('/isAdmin/{id}', [AuthController::class, 'isAdmin']);

Route::prefix('/personas')->group(function() {
    Route::post('/', [PersonasController::class, 'agregar']);
    Route::put('/{id}', [PersonasController::class, 'modificar']);
    Route::delete('/{id}', [PersonasController::class, 'eliminar']);
    Route::get('/', [PersonasController::class, 'mostrar']);
    Route::get('mostrar/{id}', [PersonasController::class, 'mostrarUnico']);
});