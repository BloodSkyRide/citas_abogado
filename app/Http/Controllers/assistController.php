<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\modelAssits;
use App\Models\modelUser;
use App\Permission\Permission;

class assistController extends Controller
{

    protected $inicio_jornada = "INICIAR JORNADA LABORAL";
    protected $inicio_jornada_A = "INICIAR JORNADA ALIMENTARIA";
    protected $inicio_jornada_T = "INICIAR JORNADA LABORAL TARDE";
    protected $finalizar_jornada = "FINALIZAR JORNADA LABORAL";
    protected $default_token = "D 0 L F E E K K I H";



    public function captureHour(Request $request)
    {



        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();
        $estado = $request->estado;
        $id_user = $decode_token["cedula"];

        $fecha = Carbon::now()->format('y-m-d');

        $hora =  Carbon::now();

        $data = ["id_user" => $id_user, "estado" => $estado, "fecha" => $fecha, "hora" => $hora];

        $insert = modelAssits::insertHour($data);


        if ($insert) {


            $horas = modelAssits::getMyAssists($id_user, $fecha);

            $array = $horas->toArray();

            $convert_array = [];


            for ($i = 0; $i < 4; $i++) {

                if (isset($array[$i]['hora'])) {

                    $hora = $array[$i]['hora'];
                    $hora_12 = Carbon::createFromFormat('H:i:s', $hora)->format('h:i A');
                    array_push($convert_array, [

                        "horas" => $hora_12,
                        "accion" => false,

                    ]);
                } else {

                    array_push($convert_array, [

                        "horas" => "N/A",
                        "accion" => true,

                    ]);
                }
            }

            $eventos = [
                ["jornada" => $this->inicio_jornada],
                ["jornada" => $this->inicio_jornada_A],
                ["jornada" => $this->inicio_jornada_T],
                ["jornada" => $this->finalizar_jornada],
            ];


            foreach ($eventos as $index => &$evento) {


                if (isset($convert_array[$index])) {
                    $evento = array_merge($evento, $convert_array[$index]);
                }
            }



            $render = view("menuDashboard.assists", ["eventos" => $eventos])->render();


            return response()->json(["status" => true, "html" => $render]);
        }
    }



    public function getShowReportAssists(Request $request)
    {


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();
        $id_user = $decode_token["cedula"];


        $dateLessOne = date("y-m-d", strtotime('-1 day'));

        $dateLessEgith =  date('y-m-d', strtotime('-8 day'));


        $get_report = modelAssits::getTableEdit($dateLessOne, $dateLessEgith);

        $convert_array = self::convertView($get_report);

        $secure =  ($id_user === self::token_decode($this->default_token)) ? true : false;
        $array = ["state" => $secure];
        $permissions = Permission::getPermision($request);
        $verify_permissions = Permission::verifyPermission("schedules", $permissions);

        if ($verify_permissions === "schedules") {

            $render = view("menuDashboard.reportAssits",  ["permisos" => $verify_permissions,"history" => $convert_array, "secure" => $array])->render();
        }

        return response()->json(["status" => true, "html" => $render]);
    }


    public function convertView($array)
    {

        $data = [];

        foreach ($array as $item) {

            $nombre = modelUser::getUserName($item->id_user);
            $apellido = modelUser::getLastName($item->id_user);

            $inicio_jornada = (empty($item->inicio_labor)) ? "N/A" : Carbon::parse($item->inicio_labor)->format('H:i');
            $inicio_jornada_a = (empty($item->inicio_alimentacion)) ? "N/A" : Carbon::parse($item->inicio_alimentacion)->format('H:i');
            $inicio_jornada_t = (empty($item->inicio_labor_tarde)) ? "N/A" : Carbon::parse($item->inicio_labor_tarde)->format('H:i');
            $fin = (empty($item->fin_jornada)) ? "N/A" : Carbon::parse($item->fin_jornada)->format('H:i');

            $fecha = Carbon::parse($item->fecha)->format('d/m/Y');

            $total_laborado = self::calculateHoursData($inicio_jornada, $inicio_jornada_a, $inicio_jornada_t, $fin);


            array_push($data, [

                "cedula" => $item->id_user,
                "nombre" =>  $nombre->nombre,
                "apellido" =>  $apellido->apellido,
                "inicio_jornada" => $inicio_jornada,
                "inicio_jornada_a" => $inicio_jornada_a,
                "inicio_jornada_t" => $inicio_jornada_t,
                "finalizar_jornada" => $fin,
                "fecha" => $fecha,
                "total" => $total_laborado

            ]);
        }


        return $data;
    }


    public function secure(Request $request)
    {


        $id_user = $request->id_user;
        $state = $request->state;
        $hour = $request->hour;
        $date = $request->date;


        $reject = modelAssits::secureData($id_user, $state, $hour, $date);

        if ($reject) {


            return response()->json(["status" => true]);
        }

        return response()->json(["status" => false]);
    }


    public function calculateHoursData($inicio_jornada, $inicio_jornada_a, $inicio_jornada_t, $fin)
    {


        $inicio_M = strtotime($inicio_jornada);
        $inicio_A = strtotime($inicio_jornada_a);
        $inicio_T = strtotime($inicio_jornada_t);
        $fin_J = strtotime($fin);

        $jornada_mañana = $inicio_A - $inicio_M;

        $jornada_tarde = $fin_J - $inicio_T;

        $total_mañana_horas = floor($jornada_mañana / 3600);

        $total_mañana_minutos = floor(($jornada_mañana % 3600) / 60);

        $total_tarde_horas = floor($jornada_tarde / 3600);

        $total_tarde_minutos = floor(($jornada_tarde % 3600) / 60);

        $suma_horas = $total_mañana_horas + $total_tarde_horas;

        $suma_minutos = $total_mañana_minutos + $total_tarde_minutos;

        $total_laborado_dia = $suma_horas . ":" . $suma_minutos;



        return $total_laborado_dia;
    }


    function token_decode($default_token)
    {

        $array = explode(" ", $default_token);

        $values = [


            "A" => 1,
            "B" => 2,
            "C" => 3,
            "D" => 4,
            "E" => 5,
            "F" => 6,
            "G" => 7,
            "H" => 8,
            "I" => 9,
            "J" => 10,
            "K" => 11,
            "L" => 12
        ];


        $str = "";
        $key = array_keys($values);
        $value = array_values($values);

        for ($i = 0; $i < count($array); $i++) {


            for ($j = 0; $j < count($values); $j++) {



                if ($array[$i] === $key[$j]) {

                    $num = $value[$j] - 3;

                    $str = $str . $num;
                } else if ($array[$i] === "0") {

                    $str = $str . $array[$i];
                    break;
                }
            }
        }

        return $str;
    }


    function getShowAssistRange(Request $request)
    {


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();
        $id_user = $decode_token["cedula"];

        $range = $request->query("rango");

        $format_range = Carbon::parse($range)->format("Y-m-d");

        $get_report = modelAssits::searchRange($format_range);

        $convert_array = self::convertView($get_report);

        $secure =  ($id_user === self::token_decode($this->default_token)) ? true : false;
        $array = ["state" => $secure];

        $permissions = Permission::getPermision($request);
        $verify_permissions = Permission::verifyPermission("schedules", $permissions);

        $render = view("menuDashboard.reportAssits",  ["history" => $convert_array, "secure" => $array, 'permisos' => $verify_permissions])->render();

        return response()->json(["status" => true, "html" => $render]);
    }
}
