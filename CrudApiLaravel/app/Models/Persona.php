<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    # Nombre de la conexion
    protected $connection = 'mongodb';

    # Nombre de la tabla / colleccion
    protected $collection = 'persona';

    # Deshabilitar las fechas de creacion y actualizacion
    public $timestamps = false;

    # Campos de la tabla
    protected $fillable = [
        'nombre',
        'apellido',
        'nacionalidad',
        'edad',
        'fecha_nacimiento',
        'nombre_padre',
        'cedula_padre',
        'nombre_madre',
        'cedula_madre'
    ];
}
