<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registrarse(Request $request)
    {
        $validacion = Validator::make(
            $request->all(), 
            [
                'nombre' => 'required|string|min:2|max:20',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6'
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'nombre.min' => 'El nombre debe tener al menos 2 caracteres',
                'nombre.max' => 'El nombre debe tener máximo 20 caracteres',

                'email.required' => 'El email es requerido',
                'email.email' => 'El email no es válido',
                'email.unique' => 'El email ya está registrado',

                'password.required' => 'La contraseña es requerida',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres'
            ]
        );

        if ($validacion->fails()) {
            return response()->json([
                'status' => 422,
                'data' => [],
                'erros' => $validacion->errors()
            ], 422);
        }

        try
        {
            $user = User::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
    
            return $user;
        }

        catch (Exception $e)
        {
            return response()->json([
                'status' => 500,
                'data' => [],
                'errors' => 'Error al registrar el usuario'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validacion = Validator::make(
            $request->all(), 
            [
                'nombre' => 'required|string|min:2|max:20',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6'
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'nombre.min' => 'El nombre debe tener al menos 2 caracteres',
                'nombre.max' => 'El nombre debe tener máximo 20 caracteres',

                'email.required' => 'El email es requerido',
                'email.email' => 'El email no es válido',

                'password.required' => 'La contraseña es requerida',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres'
            ]
        );

        if ($validacion->fails()) {
            return response()->json([
                'status' => 422,
                'data' => [],
                'erros' => $validacion->errors()
            ], 422);
        }

        try
        {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'data' => [],
                    'errors' => 'Credenciales incorrectas'
                ], 401);
            }

            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'data' => [
                    'user' => $user,
                    'token' => $token
                ],
                'errors' => []
            ], 200);
        }

        catch (Exception $e)
        {
            return response()->json([
                'status' => 500,
                'data' => [],
                'errors' => 'Error al iniciar sesión'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try
        {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 200,
                'data' => 'Sesión cerrada correctamente',
                'errors' => []
            ], 200);
        }

        catch (Exception $e)
        {
            return response()->json([
                'status' => 500,
                'data' => [],
                'errors' => 'Error al cerrar sesión'
            ], 500);
        }
    }
}
