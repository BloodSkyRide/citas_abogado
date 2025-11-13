<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class modelSell extends Model
{
    use HasFactory;
    protected $table = "historial_ventas";
    protected $fillable = [
        "id_producto_venta",
        "nombre_producto_venta",
        "descripcion_producto_venta",
        "unidades_venta",
        "id_user_cajero",
        "nombre_cajero",
        "hora",
        "fecha",
        "total_venta",
        "categoria",
        "created_at",
        "updated_at"
    ];

    public static function insertSell($data)
    {

        return self::insert($data);
    }

    public static function getSells($fecha)
    {

        // return self::where("fecha", $fecha)
        //     ->orderby("fecha", "desc")
        //     ->get();

        return self::join('productos_venta', 'historial_ventas.id_producto_venta', '=', 'productos_venta.id_producto') // INNER JOIN con la tabla 'users'
            ->where('historial_ventas.fecha', $fecha)
            ->orderBy('historial_ventas.hora', 'desc')
            ->get();

        // return self::where('historial_ventas.fecha', $fecha)
        //     ->orderBy('historial_ventas.hora', 'desc') 
        //     ->get();
    }


    public static function totalSells($fecha)
    {

        return self::where("fecha", $fecha)
            ->sum('total_venta');
    }


    public static function getUnitcategory($id_product_seller, $date){

        // return self::where("fecha", $date)
        // ->get();

        return self::select('nombre_producto_venta', DB::raw('SUM(unidades_venta) as total_vendidos'), 'id_producto_venta')
        ->where('id_producto_venta', $id_product_seller)
        ->where("fecha",$date)
        ->groupBy('nombre_producto_venta','id_producto_venta')
        ->first();

    }


    public static function unitTotalSells($fecha)
    {

        return self::select(
            'historial_ventas.id_producto_venta',
            DB::raw('MAX(productos_venta.url_imagen) AS url_imagen'),
            DB::raw('MAX(historial_ventas.nombre_producto_venta) AS nombre_producto_venta'),
            DB::raw('MAX(historial_ventas.descripcion_producto_venta) AS descripcion_producto_venta'),
            DB::raw('MAX(historial_ventas.id_user_cajero) AS id_user_cajero'),
            DB::raw('MAX(historial_ventas.hora) AS hora'),
            DB::raw('MAX(historial_ventas.fecha) AS fecha'),
            DB::raw('MAX(historial_ventas.nombre_cajero) AS nombre_cajero'),
            DB::raw('SUM(historial_ventas.unidades_venta) AS total_cantidad'),
            DB::raw('SUM(historial_ventas.total_venta) AS total_vendido')
        )
            ->join("productos_venta", "historial_ventas.id_producto_venta", "=", "productos_venta.id_producto")
            ->whereDate('fecha', $fecha)
            ->groupBy('id_producto_venta')
            ->get();
    }


        public static function unitTotalSellsCategory($fecha, $category)
    {

        return self::select(
            'historial_ventas.id_producto_venta',
            DB::raw('MAX(productos_venta.url_imagen) AS url_imagen'),
            DB::raw('MAX(historial_ventas.nombre_producto_venta) AS nombre_producto_venta'),
            DB::raw('MAX(historial_ventas.descripcion_producto_venta) AS descripcion_producto_venta'),
            DB::raw('MAX(historial_ventas.id_user_cajero) AS id_user_cajero'),
            DB::raw('MAX(historial_ventas.hora) AS hora'),
            DB::raw('MAX(historial_ventas.fecha) AS fecha'),
            DB::raw('MAX(historial_ventas.nombre_cajero) AS nombre_cajero'),
            DB::raw('SUM(historial_ventas.unidades_venta) AS total_cantidad'),
            DB::raw('SUM(historial_ventas.total_venta) AS total_vendido')      
        )
            ->join("productos_venta", "historial_ventas.id_producto_venta", "=", "productos_venta.id_producto")
            ->whereDate('fecha', $fecha)
            ->where("historial_ventas.categoria", $category)
            ->groupBy('id_producto_venta')
            ->get();
    }



    public static function getTotalForUsers($fecha)
    {


        return self::select(
            "id_user_cajero",
            "nombre_cajero",
            DB::raw('SUM(unidades_venta) AS total_unidades'),
            DB::raw('SUM(total_venta) AS total_venta')
        )
            ->where("fecha", $fecha)
            ->groupBy('id_user_cajero', 'nombre_cajero')
            ->get();
    }

    public static function getContability($month, $year,$today) {


        $startDate = "$year-$month-01"; // Primer día del mes
        $endDate = "$year-$month-$today"; // Día actual dentro del mes
    
        return self::whereBetween("fecha", [$startDate, $endDate])
            ->sum("total_venta");
    }



    public static function getMySell($date, $self_id){


        return self::where("fecha", $date)
        ->where("id_user_cajero", $self_id)
        ->sum("total_venta");
    }


    public static function verify_sell($date){

        return self::where("fecha", $date)
        ->distinct()
        ->pluck("id_user_cajero");

    }

    public static function deleteSell($id_sell){

        return self::where("id_venta", $id_sell)
        ->delete();

    }

    public static function modifySellCost($id_sell, $total_sell){


        return self::where("id_venta", $id_sell)
        ->update(["total_venta" => $total_sell]);
    }


    public static function modifyDate($id_sell, $date){


        return self::where("id_venta", $id_sell)
        ->update(["fecha" => $date]);
    }

        public static function getIdProductSeller($id_sell){


        return self::where("id_venta", $id_sell)
        ->first();

    }
}
