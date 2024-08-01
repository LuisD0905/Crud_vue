<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

# Importacion de Controlador
use App\Http\Controllers\personaController;

# Rutas para personas
Route::controller(personaController::class) -> group(function () {
    Route::get('/persona', 'lista');
    Route::post('/persona', 'crear');
    Route::put('/persona/{id}', 'actualizar');
    Route::delete('/persona/{id}', 'eliminar');
});