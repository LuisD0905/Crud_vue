<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


# Rutas para personas
Route::get('/persona', function () {
    return 'Lista de Personas';
});

Route::post('/persona/crear', function () {
    return 'Crear Personas';
});

Route::put('/persona/actualizar/{id}', function () {
    return 'Actualizar Personas';
});

Route::delete('/persona/eliminar/{id}', function () {
    return 'Eliminar Peronas';
});