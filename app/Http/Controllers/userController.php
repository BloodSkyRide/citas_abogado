<?php

namespace App\Http\Controllers;

use App\Models\modelUser;
use App\Models\labores;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Permission\Permission; 

use Illuminate\Http\Request;

class userController extends Controller
{
    public function getUserForId(Request $request)
    {

        $cedula = $request->cedula;

        $register = modelUser::getUserForId($cedula);
        
        $array_permission = self::explodeFunctionPermission($register[0]->permisos);
        $permisos = Permission::permissionsFull();
        
        return response()->json(["status" => true, "datos" => $register, "permisos" => $array_permission, "establecidos" => $permisos]);
    }


    private function explodeFunctionPermission($permissions){

        return explode(",",$permissions);

    }



    public function modifyUser(Request $request)
    {

        $apellido = $request->apellido_form;
        $cedula = $request->cedula;
        $direccion = $request->direccion_form;
        $numero_contacto_emergencia = $request->form_num_emergencia;
        $nombre_contacto_emergencia = $request->nombre_emergencia_form;
        $nombre = $request->nombre_form;
        $rol = $request->selector_rol;
        $email = $request->email_form;
        $telefono = $request->my_numero;
        $permisos = $request->permisos;

        $new_pass = $request->new_pass;
        $hash = Hash::make($new_pass);

        if($new_pass === "N/A"){



            $data = [


                
                "nombre" => $nombre,
                "apellido" => $apellido,
                "rol" => $rol,
                "direccion" => $direccion,
                "email" => $email,
                "telefono" => $telefono,
                "contacto_emergencia" => $numero_contacto_emergencia,
                "nombre_contacto" => $nombre_contacto_emergencia,
                "permisos" => $permisos
            ];


        }else{

            $data = [


                "password" => $hash,
                "nombre" => $nombre,
                "apellido" => $apellido,
                "rol" => $rol,
                "direccion" => $direccion,
                "email" => $email,
                "telefono" => $telefono,
                "contacto_emergencia" => $numero_contacto_emergencia,
                "nombre_contacto" => $nombre_contacto_emergencia,
                "permisos" => $permisos
            ];

        }






        $edit = modelUser::modifyUser($cedula, $data);

        if ($edit) {


            $users = self::convertArrayforView();



            $array_labores = labores::getLabores();

            $permissions = Permission::getPermision($request);
            $verify_permissions = Permission::verifyPermission("manage_users", $permissions);

            $render = view("menuDashboard.usersView", ["permisos" => $verify_permissions,"users" => $users, "labores" => $array_labores])->render();


            return response()->json(["status" => true, "html" => $render]);
        }

        return response()->json(["status" => false]);
    }



    public function deleteUser(Request $request)
    {

        $cedula = $request->query("cedula");

        $delete = modelUser::deleteUser($cedula);


        if ($delete) {

            $array_labores = labores::getLabores();
            $users = self::convertArrayforView();

            $render = view("menuDashboard.usersView", ["users" => $users, "labores" => $array_labores])->render();


            return response()->json(["status" => true, "html" => $render]);
        }


        return response()->json(["status" => false]);
    }



    public function convertArrayforView()
    {

        $users = modelUser::getAllUsers();

        $data = [];



        foreach ($users as $item) {



            array_push($data, [

                "cedula" => $item->cedula,
                "nombre" => $item->nombre,
                "apellido" => $item->apellido,
                "rol" => $item->rol,
                "direccion" => $item->direccion,
                "email" => $item->email,
                "contacto_emergencia" => $item->contacto_emergencia,
                "nombre_contacto" => $item->nombre_contacto,
                "telefono" => $item->telefono,
                "permisos" => $item->permisos,
                "fecha_registro" => $item->fecha_registro,

            ]);
        }

        
        return $data;
    }


    public function changePassword(Request $request)
    {

        $pass_old = $request->pass_old;
        $pass_new = $request->pass_new;
        $token = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token);


        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $user_id = $decode_token->cedula;


        $get_pass = modelUser::getuserAndPassword($user_id);

        $pass_Bd = $get_pass->password;


        $validator = Hash::check($pass_old, $pass_Bd);


        if ($validator) {

            $hash = Hash::make($pass_new);
            $insert = modelUser::changePassword($user_id, $hash);


            if ($insert) {


                JWTAuth::invalidate(JWTAuth::getToken());
                return response()->json(["status" => true, 'message' => 'Token invalidado correctamente!'], 200);
            }
        }
    }
}
