<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\modelProducts;
use App\Models\modelCompuesto;
use App\Models\modelInventario;
use App\Models\modelFoodEmployee;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Permission\Permission; 
class employeFoodController extends Controller
{
    public function getShowEmployeeFood(Request $request){

        $token_header = $request->header("Authorization");
        
        $replace = str_replace("Bearer ", "", $token_header);
        
        $decode_token = JWTAuth::setToken($replace)->authenticate();
        
        $rol = $decode_token["rol"];

        $products = modelProducts::getAllProducts();
        $hoy = date("Y-m-d");

        $table_registers = modelFoodEmployee::getRegisterActual($hoy);

        $render = view("menuDashboard.employeeFood",["products" => $products, "registers" => $table_registers, "rol" => $rol])->render();


        return response()->json(["status" => true, "html" => $render]);

    }

    public function insertFood(Request $request){

        $token_header = $request->header("Authorization");
        
        $replace = str_replace("Bearer ", "", $token_header);
        
        $decode_token = JWTAuth::setToken($replace)->authenticate();
        
        $self_id = $decode_token["cedula"];
        
        $self_name = $decode_token["nombre"] . " " . $decode_token["apellido"];
        $id_item = $request->id_item;
        $name_employee = $request->name_employee;
        $units = $request->units;
        $today = date("Y-m-d");

        $name_product = modelProducts::getNameForId($id_item);

        
        
        $get_compuesto = modelCompuesto::getComposed($id_item);
        
        $flag = 0;
        
        foreach ($get_compuesto as $item) {
            
            
            $id_item_fk = $item['id_item_fk'];
            
            $descuento = $item['descuento'];
            $descuento_final = $units * $descuento;
            
            $decrement = modelInventario::decrementInventory($id_item_fk, $descuento_final);
            
            

            $flag ++;
        }

       

        if ($flag === count($get_compuesto)){


            $data_register = [
                "nombre_cajero" => $self_name,
                "cedula" => $self_id,
                "nombre_empleado" => $name_employee,
                "unidades" => $units,
                "item_producto" => $name_product,
                "fecha" => $today

            ];

            $insert =  modelFoodEmployee::insertsData($data_register);

            return self::getShowEmployeeFood($request);
        }



    }



    public function searchForRangeFood(Request $request){

        $fecha = $request->fecha;

        $products = modelProducts::getAllProducts();

        $token_header = $request->header("Authorization");
        
        $replace = str_replace("Bearer ", "", $token_header);
        
        $decode_token = JWTAuth::setToken($replace)->authenticate();
        
        $rol = $decode_token["rol"];
        

        $table_registers = modelFoodEmployee::getRegisterActual($fecha);

        $render = view("menuDashboard.employeeFood",["products" => $products, "registers" => $table_registers, "rol" => $rol])->render();


        return response()->json(["status" => true, "html" => $render]);



    }
}
