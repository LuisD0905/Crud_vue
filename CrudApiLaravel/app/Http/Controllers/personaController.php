<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Persona;
use Symfony\Component\HttpFoundation\Response;

class personaController extends Controller
{
    # Lista de datos
    public function lista()
    {
        # Consulta a base de datos
        $personas = Persona::all();

        # Retornar la consulta
        return response() -> json($personas, 200);

    }

    # Crear datos
    public function crear(Request $request)
    {
        # Se validan los datos que entran
        $validator = Validator::make($request -> all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'nacionalidad' => 'required',
            'edad' => 'required',
            'fecha_nacimiento' => 'required',
            'nombre_padre' => 'required',
            'cedula_padre' => 'required',
            'nombre_madre' => 'required',
            'cedula_madre' => 'required'
        ]);

        # Se valida si los datos ingresados son correctos
        if ($validator -> fails()) 
        {
            # Se crea mensaje de respuesta
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator -> errors(),
                'status' => 400
            ];

            # Se retorna la respesta
            return response() -> json($data, 400);
        }

        # Se crea un dato
        $persona = Persona::create([
            'nombre' => $request -> nombre,
            'apellido' => $request -> apellido,
            'nacionalidad' => $request -> nacionalidad,
            'edad' => $request -> edad,
            'fecha_nacimiento' => $request -> fecha_nacimiento,
            'nombre_padre' => $request -> nombre_padre,
            'cedula_padre' => $request -> cedula_padre,
            'nombre_madre' => $request -> nombre_madre,
            'cedula_madre' => $request -> cedula_madre
        ]);

        # Se valida si se pudo crear el dato
        if (!$persona)
        {
            # Se crea mensaje de respuesta
            $data = [
                'message' => 'Error al crear el dato',
                'status' => 500
            ];

            # Se retorna la respesta
            return response() -> json($data, 500);
        }

        # Mensaje de respuesta si es exitoso
        $data = [
            'persona' => $persona,
            'status' => 201
        ];

        # Se retorna la respesta
        return response() -> json($data, 201);
    }

    # Actualizar el dato
    public function actualizar(Request $request, $id)
    {
        $persona = Persona::find($id);

        if (!$persona) {
            $data = [
                'message' => 'Dato no encontrado',
                'status' => 404
            ];
            return response() -> json($data, 404);
        }

        $validator = Validator::make($request -> all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'nacionalidad' => 'required',
            'edad' => 'required',
            'fecha_nacimiento' => 'required',
            'nombre_padre' => 'required',
            'cedula_padre' => 'required',
            'nombre_madre' => 'required',
            'cedula_madre' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        # Se actualizan los datos
        $persona -> nombre = $request -> nombre;
        $persona -> apellido = $request -> apellido;
        $persona -> nacionalidad = $request -> nacionalidad;
        $persona -> edad = $request -> edad;
        $persona -> fecha_nacimiento = $request -> fecha_nacimiento;
        $persona -> nombre_padre = $request -> nombre_padre;
        $persona -> cedula_padre = $request -> cedula_padre;
        $persona -> nombre_madre = $request -> nombre_madre;
        $persona -> cedula_madre = $request -> cedula_madre;

        # Se guardan los datos
        $persona -> save();

        $data = [
            'message' => 'Dato actualizado',
            'persona' => $persona,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    # Eliminar datos
    public function eliminar($id) 
    {
        # Se busca el id a eliminar
        $persona = Persona::find($id);

        # Si no se encuentra en la base de datos
        if (!$persona)
        {
            $data = [
                'message' => 'El dato a eliminar no existe',
                'status' => 500
            ];
        }

        # Se borra el dato
        $persona -> delete();

        # Mensaje de respuesta si es exitoso
        $data = [
            'message' => 'El dato fue eliminado con exito',
            'status' => 200
        ];

        # Se retorna la respesta
        return response() -> json($data, 200);
    }
}