<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\modelTransfer;
use App\Models\transfersTotalModel;
use Carbon\Carbon;
use App\Permission\Permission;

class transfersController extends Controller
{
    public function getShowTransfers(Request $request)
    {

        $fechaActual = Carbon::now();
        $today = Carbon::now()->format('Y-m-d');

        $year = $fechaActual->year;
        $month = $fechaActual->month;
        $day = $fechaActual->day;

        self::sumTransfers();



        $get_transfers_month = transfersTotalModel::getTransfersForMonth($year, $month, $day);
        $get_detail_transfers = modelTransfer::getTransfersForDay($today);

        $total_detail = modelTransfer::sumTransfers($today);

        $total_transfers = transfersTotalModel::totalSum($year, $month, $day);
        $permissions = Permission::getPermision($request);
        $verify_permissions = Permission::verifyPermission("transfer", $permissions);

        if ($verify_permissions === "transfer") {

            $render = view("menuDashboard.transfers", [
                "permisos" => $verify_permissions,
                "transferencias_mes" => $get_transfers_month,
                "transfers_today" => $get_detail_transfers,
                "total_detail" => $total_detail,
                "total_transferencias" => $total_transfers
            ])->render();
        } else if ($verify_permissions === "transfer.searcher") {


            $render = view("menuDashboard.transfers", [
                "permisos" => $verify_permissions,
                "transfers_today" => $get_detail_transfers,
                "total_detail" => $total_detail,
            ])->render();
        }


        return response()->json(["status" => true, "html" => $render]);
    }


    public function insertTransfer(Request $request)
    {

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $self_name = $decode_token["nombre"];

        $rol = $decode_token["rol"];

        $description = $request->descripcion;

        $entity_bank = $request->entidad;

        $value = $request->valor;

        $image = $request->image;

        $date = Carbon::now()->format("Y-m-d");
        $time = Carbon::now()->format("H:i:s");

        $url_image = self::saveImageTransfer($request);

        $data_insert = [
            "fecha"  => $date,
            "hora" => $time,
            "cajero_responsable" => $self_name,
            "valor" => $value,
            "url_imagen" => $url_image,
            "entidad" => $entity_bank,
            "descripcion" => $description,
            "id_cajero" => $self_id
        ];


        $insert_data = modelTransfer::insertTransfer($data_insert);

        if ($insert_data) {

            return response()->json(["status" => true]);
        }
    }

    private function saveImageTransfer($request)
    {

        $imagen = $request->file("image");

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


    private function sumTransfers()
    {


        $fechaActual = Carbon::now();

        $day = Carbon::now()->day;
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;



        for ($i = 1; $i <= $day; $i++) {

            $date_format = "$year-$month-$i";

            $exists_trasnfers = transfersTotalModel::existsTransfers($date_format);


            if ($exists_trasnfers) {

                $sum_total_transfers = modelTransfer::sumTransfers($date_format);
                $insert_update = transfersTotalModel::updateTransfers($date_format, $sum_total_transfers);
            } else {

                $sum_total_transfers = modelTransfer::sumTransfers($date_format);
                $insert_update = transfersTotalModel::insertTransfer(["fecha" => $date_format, "valor" => $sum_total_transfers]);
            }
        }
    }




    public function searchForRangeTransfers(Request $request)
    {



        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $self_name = $decode_token["nombre"];

        $date = $request->range;



        $fechaActual = Carbon::now();
        $today = Carbon::now()->format('Y-m-d');

        $year = $fechaActual->year;
        $month = $fechaActual->month;
        $day = $fechaActual->day;

        self::sumTransfers();



        $get_transfers_month = transfersTotalModel::getTransfersForMonth($year, $month, $day);
        $get_detail_transfers = modelTransfer::searchForRangeTransfers($date);

        $total_detail = modelTransfer::sumTransfers($date);

        $total_transfers = transfersTotalModel::totalSum($year, $month, $day);

        $permissions = Permission::getPermision($request);
        $verify_permissions = Permission::verifyPermission("transfer", $permissions);

        $render = view("menuDashboard.transfers", [
            "permisos" => $verify_permissions,
            "transferencias_mes" => $get_transfers_month,
            "transfers_today" => $get_detail_transfers,
            "total_detail" => $total_detail,
            "total_transferencias" => $total_transfers
        ])->render();


        return response()->json(["status" => true, "html" => $render]);
    }
}
