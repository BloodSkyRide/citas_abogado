<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\modelSell;
use App\Models\modelTransfer;
use App\Models\modelEgress;
use App\Models\modelUser;
use Carbon\Carbon;
use App\Http\Controllers\dashboardController;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Permission\Permission;

class historySellController extends Controller
{

    protected $rols;


    public function __construct()
    {
        $controller = new dashboardController();
        $this->rols = $controller->getRols();
    }

    private function getCashPerson($date)
    {

        $verify_sell = modelSell::verify_sell($date);

        $data_list = [];
        foreach ($verify_sell as $item) {


            $name = modelUser::getUserName($item);
            $last_name = modelUser::getLastName($item);
            $total_venta = modelSell::getMySell($date, $item);
            $total_transferencias = modelTransfer::getSumTransfersforUser($item, $date);
            $total_egresos = modelEgress::getEgressCaja($date, $item);

            array_push($data_list, [

                "cedula" => $item,
                "nombre" => $name->nombre,
                "apellido" => $last_name->apellido,
                "total_venta" => $total_venta,
                "total_transferencia" =>  $total_transferencias,
                "total_egresos" => $total_egresos
            ]);
        }

        return $data_list;
    }
    public function getShowHistorySell(Request $request)
    {


        $token = $request->header("Authorization");
        $replace = str_replace("Bearer ", "", $token);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $rol = $decode_token["rol"];

        $self_id = $decode_token["cedula"];

        $self_name = $decode_token["nombre"];

        $today = Carbon::now()->format('Y-m-d');

        $self_transfers = modelTransfer::getSumTransfersforUser($self_id, $today);

        $history_sells = modelSell::getSells($today);

        $total_venta = modelSell::totalSells($today);

        $total_venta_unificada = modelSell::unitTotalSells($today);

        $total_venta_users = modelSell::getTotalForUsers($today);

        $total_caja_egress = modelEgress::getEgressCaja($today, $self_id);

        $self_sell = modelSell::getMySell($today, $self_id);
        $permissions = Permission::getPermision($request);
        $verify_permissions = Permission::verifyPermission("history_sell", $permissions);

        if ($verify_permissions === "history_sell" || $verify_permissions == "history_sell.full") {

            $total_sells_for_user = self::getCashPerson($today);
            $render = view("menuDashboard.historySell", [
                "rol" => $rol,
                "historial" => $history_sells,
                "permisos" => $verify_permissions,
                "total" => $total_venta,
                "unificado" => $total_venta_unificada,
                "users" => $total_venta_users,
                "self_transfers" => $self_transfers,
                "name" => $self_name,
                "my_egress" => $total_caja_egress,
                "my_sell" => $self_sell,
                "total_users" => $total_sells_for_user,
            ])->render();
        } else if ($verify_permissions === "history_sell.searcher") {

            $render = view("menuDashboard.historySell", [
                "rol" => $rol,
                "historial" => $history_sells,
                "permisos" => $verify_permissions,
                "total" => $total_venta,
                "unificado" => $total_venta_unificada,
                "users" => $total_venta_users,
                "self_transfers" => $self_transfers,
                "name" => $self_name,
                "my_egress" => $total_caja_egress,
                "my_sell" => $self_sell
            ])->render();
        }

        return response()->json(["status" => true, "html" => $render]);
    }


    public function searchForRangeHistory(Request $request)
    {

        $token = $request->header("Authorization");
        $replace = str_replace("Bearer ", "", $token);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $self_id = $decode_token["cedula"];

        $self_name = $decode_token["nombre"];

        $rol = $decode_token["rol"];
        $today = $request->fecha;

        $history_sells = modelSell::getSells($today);

        $total_venta = modelSell::totalSells($today);

        $total_venta_unificada = modelSell::unitTotalSells($today);

        $total_venta_users = modelSell::getTotalForUsers($today);

        $self_transfers = modelTransfer::getSumTransfersforUser($self_id, $today);

        $history_sells = modelSell::getSells($today);

        $total_venta = modelSell::totalSells($today);

        $total_venta_unificada = modelSell::unitTotalSells($today);

        $total_venta_users = modelSell::getTotalForUsers($today);

        $total_caja_egress = modelEgress::getEgressCaja($today, $self_id);

        $self_sell = modelSell::getMySell($today, $self_id);

        $permissions = Permission::getPermision($request);
        $verify_permissions = Permission::verifyPermission("history_sell", $permissions);


        if ($verify_permissions == "history_sell") {


            $total_sells_for_user = self::getCashPerson($today);

            $render = view("menuDashboard.historySell", [
                "permisos" => $verify_permissions,
                "historial" => $history_sells,
                "total" => $total_venta,
                "unificado" => $total_venta_unificada,
                "users" => $total_venta_users,
                "self_transfers" => $self_transfers,
                "name" => $self_name,
                "my_egress" => $total_caja_egress,
                "my_sell" => $self_sell,
                "total_users" => $total_sells_for_user,
                "self_id" => $self_id
            ])->render();

            return response()->json(["status" => true, "html" => $render]);
        }
    }


    public function optionalHistorySell(Request $request)
    {


        $cost = $request->cost;
        $date = $request->date;
        $option = $request->option;
        $id_sell = $request->id_sell;

        $optional = ["delete", "modify", "revert"];

        if (in_array($option, $optional)) {


            $return_optional = '';

            switch ($option) {

                case 'delete':
                    $delete = modelSell::deleteSell($id_sell);
                    $return_optional = "Eliminar";

                    break;

                case 'modify':

                    if (isset($cost)) $modifySell =  modelSell::modifySellCost($id_sell, $cost);



                    if (isset($date)) $modyfyDate = modelSell::modifyDate($id_sell, $date);

                    $return_optional = "modificar";

                    break;

                case 'revert':
                    $delete = modelSell::deleteSell($id_sell);
                    $return_optional = "Revertir";

                    break;
                default:
                    # code...
                    break;
            }
        }
    }
}
