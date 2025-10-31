<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

use function Laravel\Prompts\select;

class modelUser extends Authenticatable implements JWTSubject
{
    use HasFactory;

    // Indica la tabla de la base de datos que se utilizará
    protected $table = 'users';
    protected $fillable = ['cedula', 'password', 'nombre', 'apellido', 'fecha_registro', 'fecha_notificacion', 
    'rol', 'direccion', 'email', 'telefono', 'contacto_emergencia', 'nombre_contacto','permisos', 'url', 'created_at', 'updated_at']; // asignar toda las tabla de users, recordar la captura de la fecha de creacion del usuario

    // Este método obtiene un usuario basado en la cédula
    public static function getuserAndPassword($cedula)
    {
        return self::where('cedula', $cedula)->first();
    }

    // Método requerido por JWT
    public function getJWTIdentifier()
    {
        return $this->getKey(); // devuelve el ID del usuario
    }

    // Método requerido por JWT
    public function getJWTCustomClaims()
    {
        return []; // puedes agregar datos personalizados al token si es necesario
    }

    public static function saveUser($data){

        return self::insert($data);

    }


    public static function getUserName($id_user){

        return self::where("cedula",$id_user)
        ->select("nombre")
        ->first();


    }



    public static function getLastName($id_user){

        return self::where("cedula",$id_user)
        ->select("apellido")
        ->first();

    }


    public static function getName($id_user){

        return self::where("cedula",$id_user)
        ->select("nombre")
        ->first();

    }


    public static function getAllUsers(){

        return self::orderBy('id', 'asc')->get();

    }



    public static function getUserForId($id){


        return self::where("cedula",$id)
        ->select("cedula","nombre","apellido", "id_labor", "rol", "direccion", "email", "telefono", "contacto_emergencia", "nombre_contacto")
        ->get();

    }



    public static function modifyUser($cedula, $data){

        return self::where("cedula",$cedula)->update($data);

    }



    public static function deleteUser($cedula){


        return self::where("cedula",$cedula)
        ->delete();


    }


    public static function changePassword($id_user,$password){


        return self::where("cedula", $id_user)
        ->update(["password" => $password]);


    }

    public static function getAllId(){ // se utiliza para obtener todos los id y actualizar la tabla de horarios para la update

        return self::select("cedula")->get();

    }



}
