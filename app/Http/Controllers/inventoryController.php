<?php

namespace App\Http\Controllers;

use App\Models\modelInventario;
use App\Models\modelCompuesto;
use App\Models\modelcontrol_inventarios;
use App\Models\modelProducts;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Permission\Permission;  


class inventoryController extends Controller
{

    private $category_kitchen = "cocina";
    private $category_store = "tienda";



    public function getShowInventory(Request $request)
    {

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $rol = $decode_token["rol"];

        $permissions = Permission::getPermision($request);
        $verify_permissions = Permission::verifyPermission("inventory", $permissions);

        $productos_inventario = ($verify_permissions == "inventory") ? modelInventario::getAllProducts() : modelInventario::getProductsCategory($this->category_store);
        $total_inventory = modelInventario::getTotalInventory();
        $comparative = self::comparativeInventory(date("Y-m-d"));

        $render = view("menuDashboard.inventory", ["permission" => $verify_permissions, "productos" => $productos_inventario, "total" => $total_inventory, "comparativo" => $comparative])->render();

        return response()->json(["status" => true, "html" => $render]);
    }

    public function saveInventory(Request $request)
    {

        $nombre_producto = $request->nombre_producto;
        $unidades = $request->unidades;
        $tope_min = $request->tope_min;
        $precio_costo = $request->precio_costo;
        $categoria = $request->categoria;

        $fecha = date("Y-m-d");
        $hour = date('h:i:s');

        $data_inventory = [
            "nombre" => $nombre_producto,
            "unidades_disponibles" => $unidades,
            "fecha_creacion" => $fecha,
            "hora_creacion" => $hour,
            "tope_min" => $tope_min,
            "abastecimiento" => "ABASTECIDO",
            "precio_costo" => $precio_costo,
            "estado" => "DISPONIBLE",
            "categoria" => $categoria
        ];

        $insert_product_inventory = modelInventario::createProduct($data_inventory);


        if ($insert_product_inventory) return self::getShowInventory($request);
        else return response()->json(["status" => false]);
    }


    public function editInventory(Request $request)
    {

        $unidades = $request->unidades;
        $id_inventory = $request->id_inventory;
        $precio_costo = $request->precio_costo;
        $name_inventory = $request->nombre_inventario;
        $units_establishing = $request->units_establishing;


        if ($units_establishing !== null) {


            modelInventario::changeUnits($id_inventory, $units_establishing);
        }
        if (!empty($precio_costo)) {

            modelInventario::updatePrice($id_inventory, $precio_costo);
        }

        if (!empty($name_inventory)) {


            modelInventario::changeName($id_inventory, $name_inventory);
            modelCompuesto::changeNameCompound($id_inventory, $name_inventory);
        }


        if (!empty($unidades)) {

            $get_units = modelInventario::getUnits($id_inventory)->unidades_disponibles;

            $units_final = $get_units + $unidades;

            $insert_units = modelInventario::insertUnits($id_inventory, $units_final);
        }





        return self::getShowInventory($request);
    }


    public function deleteInventory(Request $request)
    {

        $id_item = $request->id_item_inventory;

        $delete = modelInventario::deleteInventory($id_item);

        if ($delete) return self::getShowInventory($request);
        else return response()->json(["status" => false]);
    }


    private function calculateCosts($id_item_fk)
    {

        $composed = modelCompuesto::getIdProductSeller($id_item_fk);
        if(count($composed) > 1)$type_compound = "compuesto";
        
        $array_ids = [];
        if ($composed) {

            foreach ($composed as $item) {

                array_push($array_ids, [

                    "id_producto_venta" => $item['id_producto_venta']
                ]);

            }
        } else return 0;


        $flagg = 0;
        foreach ($array_ids as $item) {
            
            
            $verify_category = modelProducts::verifyCategory($item['id_producto_venta']);
            
            if (isset($verify_category->categoria) && $verify_category->categoria == "tienda" && $verify_category->tipo_producto == "unitario") {
                $flagg++;
                 return (!isset($verify_category->precio)) ? 0 : $verify_category->precio;
            }
        }
        

    }


    private function comparativeInventory($date)
    {

        $verify_inventory = modelcontrol_inventarios::verifyExists($date);
        $array_data = [];
        $date = date("Y-m-d");
        if ($verify_inventory) {

            $original_inventory = modelInventario::getProductsCategory($this->category_store);
            foreach ($original_inventory as $item) {

                $id_item_original = $item['id_item'];
                $verify_compund = modelCompuesto::verifyItemCompund($id_item_original);
                if ($verify_compund) {

                    
                    $row_product_control = modelcontrol_inventarios::getItemControl($id_item_original,$date);
                    
                    $cantidad_control = (!isset($row_product_control->unidades_disponibles)) ? 0 : $row_product_control->unidades_disponibles;
                    $restante = $item['unidades_disponibles'] - $cantidad_control;

                    $calculate_cost = self::calculateCosts($id_item_original);

                    array_push($array_data, [

                        "nombre" => $item['nombre'],
                        "item_original" => $item['unidades_disponibles'],
                        "item_control" => $cantidad_control,
                        "restante" => $restante,
                        "precio" => $calculate_cost,
                        "hora_reporte" => $row_product_control->hora_reporte,
                        "fecha_reporte" => $row_product_control->fecha_reporte,
                        "total_faltante" => ($restante * $calculate_cost) * -1
                    ]);
                }
            }
        }


        return $array_data;
    }

    private function verifyButton()
    {


        $verify = modelcontrol_inventarios::verifyExists(date("Y-m-d"));


        return $verify;
    }


    public function insertIventoryControl(Request $request)
    {

        $array_data = $request->array_data;
        $verification_button = self::verifyButton();

        if ($verification_button) return response()->json(["status" => false]);

        $flagg = 0;
        foreach ($array_data as $item) {

            $id_item = $item['id_product_original'];
            $cantidad = $item['count'];

            $row = modelInventario::verifyExists($id_item);

            $data_insert = [

                "id_original" => $id_item,
                "nombre" => $row->nombre,
                "unidades_disponibles" => $cantidad,
                "fecha_reporte" => date("Y-m-d"),
                "hora_reporte" => date('h:i:s'),
                "categoria" => $row->categoria,
            ];


            $insert = modelcontrol_inventarios::insertData($data_insert);
            $flagg++;
        }


        $finally_results = ($flagg == count($array_data)) ? true : false;

        return response()->json(["status" => $finally_results]);
    }
}
