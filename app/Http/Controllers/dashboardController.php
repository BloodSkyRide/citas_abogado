<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\labores;
use App\Models\modelUser;
use App\Models\modelSubLabores;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\modelAssits;
use Carbon\Carbon;
use App\Models\modelShedule;
use App\Models\modelOverTime;
use App\Events\RealtimeEvent;
use App\Permission\Permission;

class dashboardController extends Controller
{

    public $rols;


    public function __construct()
    {

        $this->rols = ["administrador", "super admin"];
    }

    public function getRols()
    {


        return $this->rols;
    }


    public function emitirEvento()
    {

        // evento y se le envia como parametro al constructor el string

        broadcast(new RealtimeEvent('¡Este es un mensaje en tiempo real!'));
        return response()->json(["status" => "evento emitido satisfactoriamente"]);
    }



    public function openView(Request $request)
    {
        $token = $request->query("token");

        $permissions = Permission::getPermision($request);
        $decode_token = JWTAuth::setToken($token)->authenticate();
        if ($decode_token) {

            $array = [

                "nombre" => $decode_token->nombre,
                "apellido" => $decode_token->apellido,
                "cedula" => $decode_token->cedula,
                "rol" => $decode_token->rol,
                "email" => $decode_token->email,
                "telefono" => $decode_token->telefono,
                "permisos" => $permissions

            ];
            return view('dashboard', ["array" => $array]);
        }
    }


    public function viewRegister(Request $request)
    {


        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $rol = $decode_token["rol"];

        $permissions = Permission::getPermision($request);
        $verify_permissions = Permission::verifyPermission("register_users", $permissions);

        if ($verify_permissions === "register_users" || $verify_permissions === "register_users.admin") {

            $htmlContent = view("menuDashboard.registerUser", ["permisos" => $verify_permissions])->render();

            return response()->json(["status" => true, "html" => $htmlContent]);
        }
    }


    public function saveUser(Request $request)
    {

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $rol = $decode_token["rol"];

        $verify_rol = in_array($rol, $this->rols);

        if (!$verify_rol) return response()->json(["status" => false, "message" => "Rol no válido, verifica nuevamente"]);
        try {



            $validate = $request->validate([

                "apellido" => "required|string|max:255",
                "cedula" => "required|string|unique:users,cedula",
                "contacto_emergencia" => "required|string",
                "celular" => "required|string|max:255",
                "nombre_contacto" => "required|string|max:255",
                "direccion" => "required|string|max:255",
                "email" => "required|email|unique:users,email",
                "nacimiento" => "required|date|before:" . Carbon::now()->subYears(18)->toDateString(),
                "nombre" => "required|string|max:255",
                "password" => "required|string",
                "rol" => "required|string|max:255"

            ]);




            $validate["password"] = Hash::make($validate["password"]);

            $array_request = [

                "apellido" => $validate["apellido"],
                "cedula" => $validate["cedula"],
                "contacto_emergencia" => $validate["contacto_emergencia"],
                "telefono" => $validate["celular"],
                "nombre_contacto" => $validate["nombre_contacto"],
                "direccion" => $validate["direccion"],
                "email" => $validate["email"],
                "fecha_registro" => $validate["nacimiento"],
                "nombre" => $validate["nombre"],
                "password" => $validate["password"],
                "rol" => $validate["rol"],
                "fecha_registro" => Carbon::now()
            ];



            $insert_data = modelUser::saveUser($array_request);



            if ($insert_data) {


                $insert_register_schedule = modelShedule::insertids($request->cedula); //ingresa el registro a la tabla de horarios

                if ($insert_register_schedule) return response()->json(["status" => true]);
            }
        } catch (\Throwable $th) {


            return response()->json(["status" => false, "error" => $th]);
        }
    }



    public function showManageLabor()
    {

        $labores = labores::getLabores();


        $getSubLabores = modelSubLabores::getSubLabores();


        $htmlContent = view("menuDashboard.manejoLabores", ["labores" => $labores, "sublabores" => $getSubLabores])->render();



        return response()->json(["status" => true, "html" => $htmlContent]);
    }


    public function getShowMyLabors(Request $request)
    {
        $token = $request->header("Authorization");
        $replace = str_replace("Bearer ", "", $token);

        $decode_token = JWTAuth::setToken($replace)->authenticate();

        $id_labor = $decode_token["id_labor"];

        $cedula = $decode_token->cedula;
        $state_pending = "PENDIENTE";

        $state_start = "INICIAR JORNADA LABORAL";
        $state_finish = "FINALIZAR JORNADA LABORAL";

        $fecha = Carbon::now()->format('y-m-d');

        $date_update = modelAssits::verifyStartAssist($fecha, $state_start, $cedula);


        $date_finish = modelAssits::verifyStartAssist($fecha, $state_finish, $cedula);

        if (count($date_update) > 0 && count($date_finish) < 1) {


            $getGroupLabors = modelSubLabores::getSubLaborsForId($id_labor, $state_pending);

            if ($getGroupLabors) {

                $name_labor = labores::getNameLabor($id_labor);


                $render = view("menuDashboard.myLabors", ["token" => $decode_token, "sublabors" => $getGroupLabors, "nombre_labor" => $name_labor])->render();

                return response()->json(["status" => true, "html" => $render, "token" => $decode_token]);
            }

            return response()->json(["status" => false, "messagge" => "No se pudó acceder a la base de datos para las sub labores!"]);
        } else


            return response()->json(["status" => false, "messagge" => "jornada no válida!"]);
    }



    public function getShowAssist(Request $request)
    {

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();
        $id_user = $decode_token["cedula"];
        $fecha = Carbon::now()->format('y-m-d');

        $horas = modelAssits::getMyAssists($id_user, $fecha);


        $array = $horas->toArray();

        $convert_array = [];


        for ($i = 0; $i < 4; $i++) {

            if (isset($array[$i]['hora'])) {

                $hora = $array[$i]['hora'];
                $hora_12 = Carbon::createFromFormat('H:i:s', $hora)->format('h:i A');
                array_push($convert_array, [

                    "horas" => $hora_12,
                    "accion" => false
                ]);
            } else {

                array_push($convert_array, [

                    "horas" => "N/A",
                    "accion" => true
                ]);
            }
        }

        $eventos = [
            ["jornada" => "INICIAR JORNADA LABORAL"],
            ["jornada" => "INICIAR JORNADA ALIMENTARIA"],
            ["jornada" => "INICIAR JORNADA LABORAL TARDE"],
            ["jornada" => "FINALIZAR JORNADA LABORAL"],
        ];


        foreach ($eventos as $index => &$evento) {


            if (isset($convert_array[$index])) {
                $evento = array_merge($evento, $convert_array[$index]);
            }
        }

        $render = view("menuDashboard.assists", ["eventos" => $eventos])->render();

        return response()->json(["status" => true, "html" => $render]);
    }



    public function getShowUserAdmin(Request $request)
    {

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();
        $rol = $decode_token["rol"];
        $users = modelUser::getAllUsers();

        $data = [];

        $permissions = Permission::getPermision($request);
        $verify_permissions = Permission::verifyPermission("manage_users", $permissions);

        if ($verify_permissions === "manage_users") {

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

            $array_labores = labores::getLabores();



            $render = view("menuDashboard.usersView", ["users" => $data, "labores" => $array_labores, "permisos" => $verify_permissions])->render();


            return response()->json(["status" => true, "html" => $render]);
        }
    }



    public function changePasswordShow(Request $request)
    {

        $permissions = Permission::getPermision($request);

        if (in_array("change_password", $permissions)) {


            $render = view("menuDashboard.viewChangePassword")->render();

            return response()->json(["status" => true, "html" => $render]);
        } else return response()->json(["status" => false, "message" => "Permiso invalido"]);
    }

    public function getShowNotices()
    {



        $render = view("menuDashboard.notices",)->render();


        return response()->json(["status" => true, "html" => $render]);
    }

    public function getShowOverTime(Request $request)
    {

        $token_header = $request->header("Authorization");

        $replace = str_replace("Bearer ", "", $token_header);

        $decode_token = JWTAuth::setToken($replace)->authenticate();
        $id_user = $decode_token["cedula"];

        $date_searcher =  Carbon::now()->subDays(7)->format('Y-m-d');

        $data = modelOverTime::getMyRequest($id_user, $date_searcher);


        $render = view("menuDashboard.overTimeAdmin", ["id_user" => $id_user, "request" => $data])->render();

        return response()->json(["status" => true, "html" => $render]);
    }
}
