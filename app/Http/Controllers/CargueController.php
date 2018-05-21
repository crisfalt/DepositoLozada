<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Cargue;
use Carbon\Carbon;
use App\CargueFactura; //relacion de cargue con ventas
use App\Venta;

class CargueController extends Controller
{
    //
    public function index() {
        return view('admin.cargue.index');
    }

    public function create() {
        return view('admin.cargue.create');
    }

    //metodo para filtrar los cargues por medio de fecha_inicio y fecha_fin
    public function filtrar() {
        $fecha_inicio = $_GET['fecha_inicio'];
        $fecha_final = $_GET['fecha_final'];
        $unidas = DB::table('ventas as v')
                            ->join('clientes as c','v.fk_cliente','=','c.number_id')
                            ->join('rutas as r','r.id','=','c.ruta_id')
                            ->where('v.fk_estado_venta','=',2)
                            ->whereBetween('v.fecha_entrega', array($fecha_inicio, $fecha_final))
                            ->select("c.*","r.*","v.id as factura_id","v.fk_cliente as fk_cliente","v.fk_vendedor as fk_vendedor","v.fk_estado_venta as fk_estado_venta","v.fk_bodega as fk_bodega","v.fk_forma_de_pago as fk_forma_de_pago","v.total as total","v.fecha_entrega as fecha_entrega")
                            ->orderBy('r.nombre')
                            ->distinct()
                            ->get();
        // $response = array(
        //     'status' => 'success',
        //     'msg' => $fecha_inicio.' '.$fecha_final,
        // );
        return response()->json($unidas); 
    }


    public function deldia() {
        // dd(Carbon::now()->format('Y-m-d'));
        $cargue = Cargue::where('fecha_creacion',Carbon::now()->format('Y-m-d'))->first();
        if( $cargue != null ) {
            $ventas = DB::table('ventas as v')
                            ->join('cargue_facturas as c','v.id','=','c.venta_id')
                            ->join('clientes as cl','v.fk_cliente','=','cl.number_id')
                            ->where('c.cargue_id','=',$cargue->id)
                            ->orderBy('v.id')
                            ->distinct()
                            ->get();
            // dd($ventas);
            return view('admin.cargue.deldia') -> with( compact('ventas') );                
        }
        else {
            $notification = 'No se ha generado un cargue para hoy';
            return view('admin.cargue.deldia') -> with( compact('notification') );   
        }
    }

    public function store() {
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_final = $_POST['fecha_final'];
        $fecha_actual = $_POST['fecha_actual'];
        $ids_ventas = $_POST['ids_venta'];
        if( Cargue::where('fecha_creacion',$fecha_actual)->first() != null  ) {
            $response = array(
                'status' => 'success',
                'msg' => 'Ya se ha guardado un cargue para el dia de hoy',
            );
            return response()->json($response); 
        }
        else {
            $cargue = new Cargue();
            $cargue -> fecha_creacion = $fecha_actual;
            $cargue -> fecha_inicio = $fecha_inicio;
            $cargue -> fecha_fin = $fecha_final;
            $cargue -> save();
            foreach( $ids_ventas as $venta ) {
                $cargueFactura = new CargueFactura();
                $cargueFactura -> venta_id = $venta;
                $cargueFactura -> cargue_id = $cargue -> id;
                $cargueFactura -> save();
            }
            $response = array(
                'status' => 'success',
                'msg' => 'Cargue '. $cargue -> id.' Creado con Exito !',
            );
            return response()->json($response); 
        }
        
    }

}
