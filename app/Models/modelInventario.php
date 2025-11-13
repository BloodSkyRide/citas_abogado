<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class modelInventario extends Model
{

    use HasFactory;
    protected $table = "inventario";
    protected $fillable = [ "id_item", "nombre", "unidades_disponibles", "fecha_creacion", "hora_creacion", "tope_min",  
    "abastecimiento", "estado", "categoria", "created_at", "updated_at"];


    public static function createProduct($data){

        return self::insert($data);

    }

    public static function getAllProducts(){

        return self::all();

    }

    public static function getProductsCategory($category){

        return self::where("categoria",$category)
        ->get();
    }

    public static function decrementInventory($id_item, $decrement){

        return self::where('id_item', $id_item)
        ->decrement('unidades_disponibles', $decrement);
    }

    public static function editInventoryUnits($id_item){



    }

    public static function getUnits($id_item){

        return self::where("id_item", $id_item)
        ->select("unidades_disponibles")
        ->first();
    }


    public static function insertUnits($id_item, $units){

        return self::where("id_item", $id_item)
        ->update(["unidades_disponibles" => $units]);

    }


    public static function updatePrice($id_item, $price){


        return self::where("id_item", $id_item)
        ->update(["precio_costo" => $price]);

    }

    public static function verifyExists($id_item){

        return self::where("id_item", $id_item)
        ->first();

    }

    public static function deleteInventory($id_item){


        return self::where("id_item",$id_item)
        ->delete();


    }

    public static function getTotalInventory(){


        return self::select(DB::raw('SUM(unidades_disponibles * precio_costo) AS total'))
        ->value('total');

    }


    public static function changeName($id_item, $name){


        return self::where("id_item", $id_item)
        ->update(["nombre" => $name]);


    }

    public static function changeUnits($id_item, $units){

        return self::where("id_item", $id_item)
        ->update(["unidades_disponibles" => $units]);

        
    }


    public static function verifyPasadia($id_item){

        return self::where("id_item", $id_item)
        ->exists();

    }


    public static function sumRevert($id_item, $units){

        return self::where("id_item", $id_item)
        ->increment('unidades_disponibles', $units);

    }
    
}
