<?php

namespace App\Permission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;

class Permission
{
    // lista de permisos que tiene la app en caso iniciar nuevamente o añadir mas permisos deben ser declarados aqui
    // tener en cuenta que los permisos que no tienen punto, es porque admiten completamente todo el permiso ej
    // con contability tenemos que deja ver el total de la contabilidad pero... con contability.egress significa que solo deja registrar el egreso mas no ver la contabilidad
    public static $list_permission = [
        // 🔐 Gestión de usuario
        'change_password',          // Permite cambiar la contraseña
        'manage_users',             // Acceso al módulo de usuarios
        'manage_users.admin',       // Administrar roles y permisos
        'register_users',
        'register_users.admin',           // Registrar nuevos usuarios
        'report_users',             // Ver reportes de usuarios

        // 🕒 Horarios y nómina
        'schedules',                // Ver y gestionar horarios
        'payrol',                   // Acceso al módulo de nómina

        'kitchen',
        'kitchen.searcher',
        'order_cocina',             // este permiso permite recibir las ordenes de websockets
        // 🛒 Ventas e inventario
        'product_seller',           // crear productos de venta
        'inventory',
        'inventory.edit',             // Inventario general
        'store',                    // modulo de ventas con cuadre de caja
        'store.count',              // modulo de ventas sin cuadre de caja

        // 📊 Historial
        'history_sell',             // Historial general de ventas
        'history_sell.searcher',    // Buscador en el historial en el tiempo por fechas

        // 🍽️ Alimentación de empleados
        'employee_food',            // Módulo de alimentación
        'employee_food.searcher',   // Buscador en alimentación

        // 🏨 Hotel
        'hotel',                    // Gestión de reservas o habitaciones
        'hotel.searcher',
        // 💰 Contabilidad y transferencias
        'contability',              // Contabilidad general
        'contability.egress',       // Registrar egresos
        'transfer',                 // Módulo de transferencias
        'transfer.searcher',        // Registrar transferencias nuevas
    ];




    public static function getPermision(Request $request)
    {


        $token_header = $request->header("Authorization");

        if (!isset($token_header)) $token_header = $request->query("token");


        $replace = str_replace("Bearer ", "", $token_header);


        $decode_token = JWTAuth::setToken($replace)->authenticate();


        $permissions = $decode_token["permisos"];

        $permissions_array = self::getPermissionsArray($permissions);

        $array_filter = self::filterPermision($permissions_array);

        return $array_filter;
    }


    public static function permissionsFull(){


        return self::$list_permission;
    }



    private static function filterPermision($array_permissions_token)
    {


        $array_filter = [];

        foreach ($array_permissions_token as $item) {

            if (in_array($item, self::$list_permission)) {

                array_push($array_filter, $item);
            }
        }

        return $array_filter;
    }


    private static function getPermissionsArray($text_bd_permission)
    {


        return explode(",", $text_bd_permission);
    }


    public static function verifyPermission($permission_comparative, $token_array)
    {

        foreach ($token_array as $permiso) {
            if (str_starts_with($permiso, $permission_comparative)) {

                return $permiso;
            }
        }
    }
}
