<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NotificacionCreada;
use App\Events\requestFood;
use App\Models\modelProducts;
use App\Models\modelKitchen;
use App\Models\modelSell;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Permission\Permission; 

class kitchenController extends Controller
{


    public $state_preparation = "preparacion";
    public function orderKitchen(Request $request)
    {


        $array = $request->products_kitchen;
        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();
        $cajero = $decode_token["nombre"];
        $id_cajero = $decode_token["cedula"];
        $hora = date('H:i:s');
        $fecha_actual = date('Y-m-d');

        foreach ($array as $item) {

            $nombre_producto = modelProducts::getNameProduct($item['id_item'])->first()->nombre_producto;
            $cantidad = $item['cantidad'];
            $id_producto_venta = $item['id_item'];
            $data_insert = [
                "id_producto_venta" => $id_producto_venta,
                "nombre_producto" => $nombre_producto,
                "cantidad" => $cantidad,
                "descripcion" =>  $item['description'],
                "hora" => $hora,
                "estado" => $this->state_preparation,
                "fecha" => $fecha_actual,
                "nombre_cajero" => $cajero,
                "id_cajero" => $id_cajero
            ];

            $image_product = modelProducts::getProduct($item['id_item'])->url_imagen;

            $id_order = modelKitchen::insertOrderKitchen($data_insert);


            broadcast(new NotificacionCreada(
                $nombre_producto,
                $cantidad,
                $hora,
                'pedido',
                $id_cajero,
                $item['description'],
                $cajero,
                $fecha_actual,
                $image_product,
                $id_order
            ));
            sleep(1);
        }

        return response()->json(["status" => true, "message" => "Evento emitido de manera satisfactoria"]);
    }

    private static function comparative($date)
    {


        $orders_sum = modelKitchen::unitOrderKitchen($date);

        $array_discounts = [];
        foreach ($orders_sum as $item) {

            $name_product = $item['nombre_producto'];
            $id_product_seller = $item['id_producto_venta'];
            $search_sum_sell = modelSell::getUnitcategory($id_product_seller, $date);

            $price_product = modelProducts::getProduct($id_product_seller)->precio;

            if (isset($search_sum_sell->total_vendidos)) {

                if ($item['total'] != $search_sum_sell->total_vendidos) {

                    $diferencia =  $item['total'] - $search_sum_sell->total_vendidos;

                    array_push($array_discounts, [

                        "nombre_producto" => $name_product,
                        "items_ordenados" => $item['total'],
                        "items_historial" => $search_sum_sell->total_vendidos,
                        "diferencia" => $diferencia,
                        "total_restante" => ($diferencia * $price_product) * -1

                    ]);
                }
            } else {


                array_push($array_discounts, [

                    "nombre_producto" => $name_product,
                    "items_ordenados" => $item['total'],
                    "items_historial" => 0,
                    "diferencia" => $item['total'],
                    "total_restante" => $item['total'] * $price_product

                ]);
            }
        }


        return $array_discounts;
    }
    public function getShowKitchen(Request $request)
    {


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        // $cedula = $decode_token['cedula'];
        // $role = $decode_token['rol'];
        $today = date('Y-m-d');

        $orders = modelKitchen::getOrdersToday($today);
        $orders_sum = modelKitchen::unitOrderKitchen($today);
        $order_comparative = self::comparative($today);

        $permissions = Permission::getPermision($request);
        $verify_permissions = Permission::verifyPermission("kitchen", $permissions);
        
        if($verify_permissions === "kitchen"){

            $render = view("menuDashboard.historyOrderKitchen", [
                "orders" => $orders,
                'permission' => $verify_permissions,
                "orders_sum" => $orders_sum,
                "comparativo" => $order_comparative
            ])->render();
    
        }else if($verify_permissions === "kitchen.searcher"){

                $render = view("menuDashboard.historyOrderKitchen", [
                "orders" => $orders,
                'permission' => $verify_permissions,
                "orders_sum" => $orders_sum,
                "comparativo" => $order_comparative
            ])->render();

        }
    
            return response()->json(["status" => true, "html" => $render]);


    }


    public function changeState(Request $request)
    {

        $id_order = $request->id_order;

        $state = $request->state;

        $change_state = modelKitchen::changeStateForId($id_order, $state);


        if ($change_state) {

            return self::getShowKitchen($request);
        } else return response()->json(["status" => true]);
    }



    public function changeStateButton(Request $request)
    {

        $id_order = $request->id_order;
        $state = $request->state;


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        if ($state === "preparado") {

            $order = modelKitchen::getOrderId($id_order);
            $name_order = $order->nombre_producto;
            $amount_order = $order->cantidad;
            $hora = date('H:i:s');
            $id_cajero = $decode_token['cedula'];

            broadcast(new NotificacionCreada($name_order, $amount_order,  $hora, 'devolucion', $id_cajero));
        }

        $change_state = modelKitchen::changeStateForId($id_order, $state);

        if ($change_state) return response()->json(["status" => true]);
        else return response()->json(["status" => false]);
    }


    public function getIdUser(Request $request)
    {

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token['cedula'];


        return response()->json(["status" => true, "id_access" => $self_id]);
    }


    public static function getRange(Request $request)
    {


        $range = $request->range;

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $cedula = $decode_token['cedula'];
        $role = $decode_token['rol'];
        $orders_sum = modelKitchen::unitOrderKitchen($range);
        $order_comparative = self::comparative($range);
        $orders = modelKitchen::getOrdersToday($range);

        $render = view("menuDashboard.historyOrderKitchen", [
            "orders" => $orders,
            'id' => $cedula,
            "orders_sum" => $orders_sum,
            "rol" => $role,
            "comparativo" => $order_comparative
        ])->render();


        return response()->json(["status" => true, "html" => $render]);
    }
}
