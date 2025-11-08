<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\modelGuest;
use App\Models\modelSell;
use App\Models\modelProducts;
use App\Models\modelInventario;
use App\Models\modelReservations;
use App\Models\modelTransfer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use App\Permission\Permission;
use Illuminate\Http\Request;

class guestController extends Controller
{


    protected $id_defecto = 500; // id por defecto para crear el producto de venta correspondiente a la alquilada de las habitaciones
    protected $id_pasadia_amarilla = 45;
    protected $nombre_pasadia_amarilla = "pasadia HOTEL";
    protected $type_acomodation = "Habitacion";
    protected $name_business = "Eco Hotel Parador de Rapi";
    protected $rnt_business = 52741;
    public function getShowGuest(Request $request)
    {

        $token = $request->header("Authorization");
        $replace = str_replace("Bearer ", "", $token);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $rol = $decode_token["rol"];

        $fecha = date('Y-m-d');
        $guests = modelGuest::getGuest($fecha);
        $total_guests_sell = modelGuest::totalSellGuests($fecha);
        $reserevations = modelReservations::getReservations($fecha);
        $permissions = Permission::getPermision($request);
        $verify_permissions = Permission::verifyPermission("hotel", $permissions);

        if ($verify_permissions === "hotel" || $verify_permissions === "hotel.searcher") {

            $render = view("menuDashboard.guest", ["permisos" => $verify_permissions, "guests" => $guests, "total" => $total_guests_sell, "reservations" => $reserevations])->render();
        }

        return response()->json(["status" => true, "html" => $render]);
    }



    private function verifyProductSellerRoom()
    {



        $verificador = modelProducts::verifyProductSeller($this->id_defecto);

        $confirmation = count($verificador);

        if ($confirmation > 0) return false;
        else {

            $data = [
                "id_producto" => $this->id_defecto,
                "nombre_producto" => "Habitacion",
                "precio" => "0",
                "descripcion" => "Comoda habitacion en eco hotel parador de rapi",
                "fecha_creacion" => "2024-12-19",
                "url_imagen" => "storage/product_images/product_defect.png"
            ];

            modelProducts::insertProduct($data);
        }
    }


    public function sendregister(Request $request)
    {

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $self_name = $decode_token["nombre"] . " " . $decode_token["apellido"];

        $registros = $request->json()->all();
        $precio_alquiler = $request->precio;
        $tipo_estadia = $request->estadia;

        self::verifyProductSellerRoom();
        $hora =  Carbon::now();
        $fecha = date('Y-m-d');
        $fecha_mas_un_dia = date('Y-m-d', strtotime($fecha . ' +1 day'));
        $verify_pasadia = modelInventario::verifyPasadia($this->id_pasadia_amarilla);

        if (!$verify_pasadia) {

            $data_inventory = [

                "id_item" => $this->id_pasadia_amarilla,
                "nombre" => $this->nombre_pasadia_amarilla,
                "unidades_disponibles" => 200, // cantidad de unidades disponibles
                "fecha_creacion" => $fecha,
                "hora_creacion" => $hora,
                "tope_min" => 50,
                "abastecimiento"  => "ABASTECIDO",
                "precio_costo" => 270,
                "estado" => "DISPONIBLE",

            ];

            modelInventario::createProduct($data_inventory);
        }



        $confirmation = count($registros['registros']);


        $precio_divisor = $precio_alquiler / $confirmation;


        $flag = 0;

        $principalCode = null;

        foreach ($registros['registros'] as $item) {


            $data = [

                "nombre_huesped" => $item['nombres'],
                "apellido_huesped" => $item['apellidos'],
                "tipo_documento" => $item['tipo_documento'],
                "cedula_huesped" => $item['cedula'],
                "acompanantes" => $item['numero_acompanantes'],
                "nacimiento" => $item['nacimiento'],
                "email" => $item['email'],
                "origen" => $item['origen'],
                "destino" => $item['destino'],
                "estado_civil" => $item['estado_civil'],
                "celular" => $item['celular'],
                "hora" => $hora,
                "habitacion" => $item['habitacion'],
                "estadia" => $tipo_estadia,
                "total_venta" => $precio_divisor,
                "fecha" => $fecha,


            ];


            $insert = modelGuest::insertGuests($data);

            if ($insert) $flag++;

            $flagg_second = 0;

            if ($flag == 1) {

                $response = Http::withHeaders([
                    'Authorization' => 'token vwSeTgu4uJjoqyEaezcf1Cu3VWaRZKx4EdsaW5qn',
                    'Accept' => 'application/json'
                ])->post('https://pms.mincit.gov.co/one/', [
                    // Aquí van los datos que quieras enviar en el body
                    'tipo_identificacion' => $item['tipo_documento'],
                    'numero_identificacion' => $item['cedula'],
                    'nombres' => $item['nombres'],
                    'apellidos' => $item['apellidos'],
                    'cuidad_residencia' => $item['origen'],
                    'cuidad_procedencia' => $item['destino'],
                    'numero_habitacion' => $item['habitacion'],
                    'motivo' => 'trabajo',
                    'check_in' => $fecha,
                    'check_out' => $fecha_mas_un_dia,
                    'numero_acompanantes' => $item['numero_acompanantes'],
                    'costo' => $this->type_acomodation,
                    'tipo_acomodacion' => $precio_alquiler / 2,
                    'nombre_establecimiento' => $this->name_business,
                    'rnt_establecimiento' => $this->rnt_business,
                ]);

                if ($item['numero_acompanantes'] > 0) $principalCode = data_get($response->json(), 'code');

                $flagg_principal = 0;

                $flagg_principal = (isset($principalCode)) ? $flagg_principal += 1 : $principalCode;
            } else {

                if (isset($principalCode)) {


                    $flagg_second++;
                    $response = Http::withHeaders([
                        'Authorization' => 'token vwSeTgu4uJjoqyEaezcf1Cu3VWaRZKx4EdsaW5qn',
                        'Accept' => 'application/json'
                    ])->post('https://pms.mincit.gov.co/one/', [
                        // Aquí van los datos que quieras enviar en el body
                        'tipo_identificacion' => $item['tipo_documento'],
                        'numero_identificacion' => $item['cedula'],
                        'nombres' => $item['nombres'],
                        'apellidos' => $item['apellidos'],
                        'cuidad_residencia' => $item['origen'],
                        'cuidad_procedencia' => $item['destino'],
                        'numero_habitacion' => $item['habitacion'],
                        'check_in' => $fecha,
                        'check_out' => $fecha_mas_un_dia,
                        'padre' => $principalCode,
                    ]);
                }
            }
        }

        $data_sell = [

            "id_producto_venta" => $this->id_defecto,
            "nombre_producto_venta" => "Habitacion " . $item['habitacion'],
            "descripcion_producto_venta" => "Cómoda habitacion en el eco hotel parador de rapi.",
            "unidades_venta" => $confirmation,
            "id_user_cajero" => $self_id,
            "nombre_cajero" => $self_name,
            "hora" => $hora,
            "fecha" => $fecha,
            "total_venta" => $precio_alquiler
        ];
        modelSell::insertSell($data_sell);



        $validate2 = ($flagg_second > 0) ? " además se registran $flagg_second acompañantes" : "";

        if ($flagg_principal > 0) {

            $validate = "Se registró el principal exitosamente";
        } else if (!isset($flagg_principal) && $item['numero_acompanantes'] < 1) {


            $validate = "No se registran acompañantes";
        } else if (!isset($flagg_principal) && $item['numero_acompanantes'] > 0) {



            $validate = "parece que no se pudo registrar en el TRA";
        }

        $validate_total = "$validate $validate2";



        if ($flag === $confirmation) {

            modelInventario::decrementInventory($this->id_pasadia_amarilla, $confirmation);

            return response()->json(["status" => true, "message" => $validate_total]);
        } else {

            return response()->json(["status" => false, "mesagge" => "No se completo el guardado correctamente!"]);
        }
    }


    public function getRange(Request $request)
    {


        $fecha = $request->fecha;

        $token = $request->header("Authorization");
        $replace = str_replace("Bearer ", "", $token);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $rol = $decode_token["rol"];
        $guests = modelGuest::getGuest($fecha);
        $total_guests_sell = modelGuest::totalSellGuests($fecha);
        $reserevations = modelReservations::getReservations($fecha);
        $permissions = Permission::getPermision($request);
        $verify_permissions = Permission::verifyPermission("hotel", $permissions);
        $render = view("menuDashboard.guest", ["permisos" => $verify_permissions, "guests" => $guests, "total" => $total_guests_sell, "reservations" => $reserevations])->render();

        return response()->json(["status" => true, "html" => $render]);
    }

    private function createIdUnit()
    {

        $codigo = rand(10000, 99999);
        return $codigo;
    }



    private function saveBill($request)
    {

        $imagen = $request->file("comprobante");

        // Nombre final del archivo
        $name_final = pathinfo($imagen->getClientOriginalName(), PATHINFO_FILENAME) . "_" . Carbon::now()->format('Y-m-d_H-i-s') . ".jpg";
        $full_path = storage_path("app/public/transfers/" . $name_final);

        // Optimizar imagen antes de guardarla
        $this->optimizeImage($imagen, $full_path);

        return "storage/transfers/" . $name_final;
    }

    private function optimizeImage($image, $destination)
    {
        $src = imagecreatefromjpeg($image->getPathname());
        imagejpeg($src, $destination, 50);

        imagedestroy($src);
    }


    public function makeReservation(Request $request)
    {

        $token = $request->header("Authorization");
        $replace = str_replace("Bearer ", "", $token);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $titular = $request->titular;
        $telefono = $request->telefono;
        $fecha = $request->fecha;
        $documento = $request->documento;
        $medio_pago = $request->medio_pago;
        $contacto = $request->contacto;
        $huespedes = $request->huespedes;
        $descripcion = $request->descripcion;
        $monto_reserva = $request->monto_reserva;
        $valor_paquete = $request->valor_paquete;

        $save_bill = 0;


        $rol = $decode_token["rol"];
        $hoy = date('Y-m-d');
        $time = date('H:i:s');

        $id_unit = self::createIdUnit();

        $amount =  $valor_paquete - $monto_reserva;

        $data_insert = [
            "monto_reservado" => $monto_reserva,
            "monto_adeudado" => $amount,
            "valor_paquete" => $valor_paquete,
            "titular" => $titular,
            "chat" => $telefono,
            "fecha_reservacion" => $fecha,
            "cedula" => $documento,
            "medio_pago" => $medio_pago,
            "contacto" => $contacto,
            "numero_huespedes" => $huespedes,
            "descripcion_reserva" => $descripcion,
            "fecha" => $hoy,
            "hora_reserva" => $time,
            "id_reserva_unit" => $id_unit,
            "estado" => "RESERVADO"
        ];

        if ($medio_pago === "transferencia") {


            $path_image = self::saveBill($request);

            $data = ["valor" => $monto_reserva, "url_imagen" => $path_image];

            $save_bill = modelTransfer::insertTransferGetId($data);

            $data_insert["id_transferencia"] = $save_bill;
        }
        $insert = modelReservations::insertReservations($data_insert);

        if ($insert) {

            return response()->json(["status" => true, "mesagge" => "Reservación realizada con exito!", "datos" => $data_insert]);
        }
    }


    public function searchReservation(Request $request)
    {

        $code = $request->codigo;

        $verify_code = modelReservations::getCodeReservation($code);

        $results = ($verify_code) ? true : false;


        return response()->json(["status" => true, "results" => $results, "datos" => $verify_code]);
    }


    public function redeemCode(Request $request)
    {


        $id_reserva = $request->id_reserva;
        $payment_method = modelReservations::getIdTransfer($id_reserva)->medio_pago;
        $change_state = modelReservations::changeStateReservation($id_reserva, "REDIMIDO");

        if ($payment_method == "transferencia") {

            $tittle_reservation = modelReservations::getIdTransfer($id_reserva)->titular;
            $tittle_id = modelReservations::getIdTransfer($id_reserva)->cedula;
            $token = $request->header("Authorization");
            $replace = str_replace("Bearer ", "", $token);

            $decode_token = JWTAuth::setToken($replace)->authenticate();

            $cajero = $decode_token["nombre"];

            $id_cajero = $decode_token["cedula"];

            $id_transfer = modelReservations::getIdTransfer($id_reserva)->id_transferencia;

            $hoy = date('Y-m-d');
            $time = date('H:i:s');


            $data_change = [
                "fecha" => $hoy,
                "hora" => $time,
                "cajero_responsable" => $cajero,
                "id_cajero" => $id_cajero,
                "descripcion" => "Abono reservacion de $tittle_reservation con cedula: $tittle_id"
            ];

            $charge_transfer = modelTransfer::setTransfer($id_transfer, $data_change);
        }

        $messagge = ($change_state) ? "Reservación redimida con exito!" : "No se pudo redimir la reservación!";


        if ($change_state) {

            return response()->json(["status" => true, "mesagge" => $messagge]);
        }
    }
}
