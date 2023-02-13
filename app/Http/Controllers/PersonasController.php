<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonasController extends Controller
{
    public function agregar(Request $request)
    {
        $validacion = Validator::make(
            $request->all(),
            [
                "nombre" => "required|min:2,max:20",
                "ap_paterno" => "required|min:2,max:20",
                "ap_materno" => "required|min:2|max:20",
                "sexo" => "required|in:,M,F,O",
                "f_nac" => "required|date",
            ],
            [
                "nombre.required" => "El nombre es requerido",
                "nombre.min" => "El nombre debe tener al menos 2 caracteres",
                "nombre.max" => "El nombre debe tener máximo 20 caracteres",

                "ap_paterno.required" => "El apellido paterno es requerido",
                "ap_paterno.min" => "El apellido paterno debe tener al menos 2 caracteres",
                "ap_paterno.max" => "El apellido paterno debe tener máximo 20 caracteres",

                "ap_materno.required" => "El apellido materno es requerido",
                "ap_materno.min" => "El apellido materno debe tener al menos 2 caracteres",
                "ap_materno.max" => "El apellido materno debe tener máximo 20 caracteres",

                "sexo.required" => "El sexo es requerido",
                "sexo.in" => "El sexo debe ser M, F u O",

                "f_nac.required" => "La fecha de nacimiento es requerida",
                "f_nac.date" => "La fecha de nacimiento debe ser una fecha válida",
            ]
        );

        if($validacion->fails()){
            return response()->json([
                "errors" => $validacion->errors()
            ], 400);
        }

        $persona = Persona::create([
            "nombre" => $request->nombre,
            "ap_paterno" => $request->ap_paterno,
            "ap_materno" => $request->ap_materno,
            "sexo" => $request->sexo,
            "f_nac" => $request->f_nac,
        ]);

        if($persona->save())
        {
            return $persona;
        }
        else
        {
            return response()->json([
                "errors" => "No se pudo guardar la persona"
            ], 500);
        }
    }

    public function modificar(Request $request, $id)
    {
        $validacion = Validator::make(
            $request->all(),
            [
                "nombre" => "required|min:2,max:20",
                "ap_paterno" => "required|min:2,max:20",
                "ap_materno" => "required|min:2|max:20",
                "sexo" => "required|in:,M,F,O",
                "f_nac" => "required|date",
            ],
            [
                "nombre.required" => "El nombre es requerido",
                "nombre.min" => "El nombre debe tener al menos 2 caracteres",
                "nombre.max" => "El nombre debe tener máximo 20 caracteres",

                "ap_paterno.required" => "El apellido paterno es requerido",
                "ap_paterno.min" => "El apellido paterno debe tener al menos 2 caracteres",
                "ap_paterno.max" => "El apellido paterno debe tener máximo 20 caracteres",

                "ap_materno.required" => "El apellido materno es requerido",
                "ap_materno.min" => "El apellido materno debe tener al menos 2 caracteres",
                "ap_materno.max" => "El apellido materno debe tener máximo 20 caracteres",

                "sexo.required" => "El sexo es requerido",
                "sexo.in" => "El sexo debe ser M, F u O",

                "f_nac.required" => "La fecha de nacimiento es requerida",
                "f_nac.date" => "La fecha de nacimiento debe ser una fecha válida",
            ]
        );

        if($validacion->fails()){
            return response()->json([
                "errors" => $validacion->errors()
            ], 400);
        }

        $persona = Persona::find($id);

        if($persona)
        {
            $persona->nombre = $request->nombre;
            $persona->ap_paterno = $request->ap_paterno;
            $persona->ap_materno = $request->ap_materno;
            $persona->sexo = $request->sexo;
            $persona->f_nac = $request->f_nac;

            if($persona->save())
            {
                return $persona;
            }
            else
            {
                return response()->json([
                    "errors" => "No se pudo modificar la persona"
                ], 500);
            }
        }

        return response()->json([
            "errors" => "No se encontró la persona"
        ], 404);
    }

    public function eliminar($id)
    {
        $persona = Persona::find($id);

        if($persona)
        {
            if($persona->delete())
            {
                return response()->json([
                    "data" => "Se eliminó la persona"
                ], 200);
            }
            else
            {
                return response()->json([
                    "errors" => "No se pudo eliminar la persona"
                ], 500);
            }
        }

        return response()->json([
            "errors" => "No se encontró la persona"
        ], 404);
    }

    public function mostrar()
    {
        return Persona::all();
    }

    public function mostrarUnico($id)
    {
        $persona = Persona::find($id);

        if($persona)
        {
            return $persona;
        }

        return response()->json([
            "errors" => "No se encontró la persona"
        ], 404);
    }
}
