<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Payload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\modelUser;
use Illuminate\Support\Facades\Http;


class AuthController extends Controller
{
    //


    public function login(Request $request)
    {
        $cedula = $request->cedula;
        $password = $request->pass;

        $token = modelUser::getuserAndPassword($cedula);
        
        $pass_bd = $token->password;
        $validator = Hash::check($password, $pass_bd);

        if ($validator) { // clase para validar las claves hash traidas desde el model

            $payload = [

                "nombre" => $token->nombre,
                "cedula" => $token->cedula,
                "apellido" => $token->apellido,
                "rol" => $token->rol,
                "email" => $token->email,
                "telefono" => $token->telefono,
                "password" => $password,
                "permisos" => $token->permisos
            ];



            $create_token = JWTAuth::attempt($payload);
            // $user = auth()->user();

            return response()->json(["access_token" => $create_token, "status" => true]);
        } else {

            return response()->json(["message" => "clave erronea", "status" => false]);
        }

        return response()->json(["status" => $cedula]);
    }




    public function logout()
    {


        try {
            // Invalidar el token actual
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                "status" => true,
                'message' => 'Cierre de sesión exitoso'
            ], 200);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            // Manejar el caso de un token inválido o expirado
            return response()->json([

                "status" => false,
                'message' => 'Error al intentar cerrar sesión, token no válido'
            ], 500);
        }
    }
}
