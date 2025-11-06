<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Js;
use Carbon\Carbon;
use App\Models\modelInventario;
use App\Models\modelProducts;
use App\Models\modelCompuesto;
use App\Models\modelSell;
use App\Models\modelAssits;
use App\Models\modelcontrol_inventarios;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use App\Permission\Permission; 


use function Laravel\Prompts\confirm;

class createProductController extends Controller
{


    

    private function deleteItem($id_item){

        $get_original_path = modelProducts::getPathForId($id_item)->url_imagen;
        $flag = 0;

        
        if(file_exists($get_original_path) && $get_original_path !== "storage/product_images/product_defect.png"){

            $flag ++;
            unlink($get_original_path);
        }

        if($get_original_path === "storage/product_images/product_defect.png") $flag++;

        return ($flag > 0) ? true : false;

    }


    public function deleteCompound(Request $request){

        $id_item = $request->id_item;

        $delete_image = self::deleteItem($id_item);

        if($delete_image){

            $delete_product = modelProducts::deleteRegister($id_item);
            $delete_compund = modelCompuesto::deleteCompoundForId($id_item);

            if($delete_compund && $delete_product){

            $productos_inventario = modelInventario::getAllProducts();
            $products_compound = modelProducts::getAllProducts();
            $render = view("menuDashboard.createProduct", ["productos" => $productos_inventario, "compuestos" => $products_compound])->render();
            return response()->json(["html" => $render,"status" => true]);

            }

        }


        return response()->json(["status" => false, "message" => "Parece que el registro del compuesto no se ha elimnado o/y el registro de venta!"]);
    }


    public function editProductCompund(Request $request){


        $id_item = $request->id_item_compund;
        $description = $request->edit_description;
        $modify_cost = $request->modify_cost;
        $image = $request->image;
        $name = $request->name;

        $confirm = [];

        if($image !== "undefined"){
            
            array_push($confirm, "imagen");
            
            $get_new_path = self::modifyImage($id_item, $image);

            modelProducts::modifyImage($id_item, $get_new_path);
        }
        if(!empty($description)){
            array_push($confirm, "descripción");
            modelProducts::modifyDescription($id_item,$description);
            
        }

        if(!empty($modify_cost)){
            
            array_push($confirm, "costo");
            
            modelProducts::modifyCost($id_item, $modify_cost);
        }


        if(!empty($name)){
            
            array_push($confirm, "nombre");
            
            modelProducts::editName($id_item, $name);
        }


        $final = implode(', ', $confirm);

        $productos_inventario = modelInventario::getAllProducts();
        $products_compound = modelProducts::getAllProducts();
        $render = view("menuDashboard.createProduct", ["productos" => $productos_inventario, "compuestos" => $products_compound])->render();

        if(count($confirm) > 0) return response()->json(["html" => $render,"status" => true, "message" => "Se editó de manera satisfactoria los siguientes cambios: ".$final]);
        else return response()->json(["status" => false]);

        
    }



    private function modifyImage($id_item, $image){


        $file_name = $image->getClientOriginalName();
        
        $query_path = modelProducts::getPathForId($id_item)->url_imagen;
        
        $get_original_path = modelProducts::getPathForId($id_item)->url_imagen;
        
        

        if(file_exists($get_original_path) && $get_original_path !== "storage/product_images/product_defect.png"){

            
            
            unlink($get_original_path);
        }

        $base_name = pathinfo($file_name, PATHINFO_FILENAME);
        $root_path = 'storage/product_images';
        $hoy = Carbon::now()->format('Y-m-d');

        $name_final = $base_name . "_" . $hoy;
        $path = $image->storeAs("product_images", $name_final . ".png", "public");
        return $root_path . "/" . $name_final . ".png";

    }


    public function createProducts(Request $request)
    {
        
        $permissions = Permission::getPermision($request);
        $verify_permissions = Permission::verifyPermission("product_seller", $permissions);
        if($verify_permissions === "product_seller"){

            $productos_inventario = modelInventario::getAllProducts();
            $products_compound = modelProducts::getAllProducts();
            $render = view("menuDashboard.createProduct", ["productos" => $productos_inventario, "compuestos" => $products_compound])->render();
    
            return response()->json(["status" => true, "html" => $render]);

        }
    }


    private function saveImageProduct($image)
    {

        $file_name = $image->getClientOriginalName();
        $base_name = pathinfo($file_name, PATHINFO_FILENAME);
        $root_path = 'storage/product_images';
        $hoy = Carbon::now()->format('Y-m-d');

        $name_final = $base_name . "_" . $hoy;
        $path = $image->storeAs("product_images", $name_final . ".jpg", "public");
        return $root_path . "/" . $name_final . ".jpg";
    }

    public function saveProduct(Request $request)
    {

        $array = json_decode($request->array, true);
        $nombre = $request->nombre;
        $precio_producto = $request->precio;
        $description = $request->description;
        $category = $request->categoria;
        $type_product = $request->tipo_producto;
        $hoy = date("Y-m-d");

        $image = $request->image;
 
        $url_image = "";

        if($image === "undefined"){

            $url_image = "storage/product_images/product_defect.png";
            

        }else $url_image = self::saveImageProduct($image);


        $data = ["nombre_producto" => $nombre, "categoria" => $category ,"precio" => $precio_producto, "descripcion" => $description, "fecha_creacion" => $hoy, "tipo_producto" => $type_product,"url_imagen" => $url_image];


        $insert_product = modelProducts::insertProduct($data);


        foreach ($array as $compuesto) {

            $nombre_inventory = $compuesto["item_inventario"];
            $id_item_inventory = $compuesto["id_item"];
            $discount = $compuesto["input_descuento"];

            $insert_data = ["id_producto_venta" => $insert_product, "nombre_compuesto" => $nombre_inventory, "id_item_fk" => $id_item_inventory,  "descuento" => $discount, "fecha_creacion" => $hoy];

            $insert_compound = modelCompuesto::insertCompound($insert_data);
        }

        $productos_inventario = modelInventario::getAllProducts();
        $products_compound = modelProducts::getAllProducts();
        $render = view("menuDashboard.createProduct", ["productos" => $productos_inventario, "compuestos" => $products_compound])->render();


        return response()->json(["status" => true, "html" => $render]);
    }

    public function getShowStore(Request $request)
    {

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $rol = $decode_token["rol"];

        $today = date("Y-m-d");
        $state_start = "INICIAR JORNADA LABORAL";
        $state_end = "FINALIZAR JORNADA LABORAL";
        $verify_Assists_start = modelAssits::verifyStartAssist($today, $state_start, $self_id);
        $verify_Assists_end = modelAssits::verifyStartAssist($today, $state_end, $self_id);

        if ($rol == "usuario") {
            if (count($verify_Assists_start) > 0 && count($verify_Assists_end) < 1 ) {


                $render = view("menuDashboard.store")->render();

                return response()->json(["status" => true, "html" => $render]);
            } else return response()->json(["status" => false]);
        }else{

            $render = view("menuDashboard.store")->render();
            return response()->json(["status" => true, "html" => $render]);

        }
    }

    public function getSearch(Request $request)
    {


        $search_text = $request->search_text;

        $search = modelProducts::searcher($search_text);

        $render = view("menuDashboard.searcherTemplate", ["productos" => $search])->render();

        return response()->json(["status" => true, "html" => $render]);
    }


    public function kitchenOrder(Request $request)
    {

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $self_name = $decode_token["nombre"] . " " . $decode_token["apellido"];

        $array = $request->data;
        $aux = 0;

        foreach ($array as $item) {
            $aux++;
            modelSell::updateStateOrder($item['id_item'], "EN PREPARACIÓN");
        }

        return ($aux === count($array)) ? response()->json(["status" => true]) : response()->json(["status" => false]); 



    }

    public function sell(Request $request)
    {

 
        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $self_name = $decode_token["nombre"] . " " . $decode_token["apellido"];

        $array = $request->data;
        $aux = 0;


        foreach ($array as $item) {
            $aux++;
            $id_producto_venta = $item['id_item'];
            $get_compuesto = modelCompuesto::getComposed($id_producto_venta);

            // data historial

            $data_product = modelProducts::getProduct($id_producto_venta);
            $nombre_producto = $data_product->nombre_producto;
            $descripcion_producto = $data_product->descripcion;
            $precio_producto = $data_product->precio;


            $decrement = $item['cantidad'];
            $categoria = $item['categoria'];
            // historial de ventas

            $hour = date('H:i:s');
            $fecha = date('Y-m-d');

            $total_venta = $decrement * $precio_producto;


            $bandera = 0;

            foreach ($get_compuesto as $compuesto) {

                $id_item_fk = $compuesto['id_item_fk'];
                
                $descuento = $compuesto['descuento'];
                $descuento_final = $decrement * $descuento;
                modelInventario::decrementInventory($id_item_fk, $descuento_final);
                $verify_date_report = modelcontrol_inventarios::verifyExists($fecha);
                if($categoria == "tienda" && $verify_date_report) modelcontrol_inventarios::decrementControlInventory($id_item_fk, $descuento_final,$fecha);
                $bandera++;
            }

            if ($bandera === count($get_compuesto)) {


                $data_sell = [
                    "id_producto_venta" => $id_producto_venta,
                    "nombre_producto_venta" => $nombre_producto,
                    "descripcion_producto_venta" => $descripcion_producto,
                    "unidades_venta" => $decrement,
                    "id_user_cajero" => $self_id,
                    "nombre_cajero" => $self_name,
                    "hora" => $hour,
                    "fecha" => $fecha,
                    "total_venta" => $total_venta,
                    "categoria" => $categoria
                ];
                modelSell::insertSell($data_sell);
            }
        }

        return ($aux === count($array)) ? response()->json(["status" => true]) : response()->json(["status" => false]);
    }


    public function informationProduct(Request $request){

        $id_product_venta = $request->id_item;

        $product_row = modelCompuesto::getComposed($id_product_venta);


        return response()->json(["status" => true, "producto" => $product_row]);


    }
}
