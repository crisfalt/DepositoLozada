<?php

namespace App\Http\Controllers;

use App\DiasRutas;
use App\Zona;
use Illuminate\Http\Request;
use DB;
use App\Cargue;
use Carbon\Carbon;
use App\CargueFactura; //relacion de cargue con ventas
use App\Venta;
use App\Ruta;

class CargueController extends Controller
{
    //
    public function index() {
        return view('admin.cargue.index');
    }

    public function create() {
        setlocale(LC_ALL,"es_ES");
        $diaActual = strtoupper(strftime("%A"));
        $zonasPorDia = Zona::with('rutas')
                            ->leftJoin('rutas as r','r.zona_id','=','zonas.id')
                            ->leftJoin('dias_rutas as dr','r.id','=','dr.ruta_id')
                            ->where('dr.dia','=',$diaActual)
                            ->where('r.estado','=','A')
                            ->select("zonas.*","r.id as ruta_id","r.nombre as ruta_nombre","r.zona_id as ruta_zona_id","dr.id as dias_rutas_id","dr.dia as dia","dr.ruta_id as dias_rutas_ruta_id")
                            ->orderBy('zonas.id')
                            ->distinct('zonas.id','r.zona_id')
                            ->get();
        $primerId = $zonasPorDia[0]->id;
//        dd($zonasPorDia);
        return view('admin.cargue.create')->with(compact('diaActual','zonasPorDia','primerId'));
    }

    //metodo para filtrar los cargues por medio de fecha_inicio y fecha_fin
    public function filtrar() {
        $fecha_inicio = $_GET['fecha_inicio'];
        $fecha_final = $_GET['fecha_final'];
        $rutas = Ruta::with('clientes')
                            ->join('clientes as c','rutas.id','=','c.ruta_id')
                            ->join('ventas as v','v.fk_cliente','=','c.number_id')
                            ->where('rutas.estado','=','A')
                            ->where('v.fk_estado_venta','=',2)
                            ->whereBetween('v.fecha_entrega', array($fecha_inicio, $fecha_final))
                            ->select("rutas.*")
                            ->orderBy('rutas.nombre')
                            ->distinct()
                            ->get();
        // $response = array(
        //     'status' => 'success',
        //     'msg' => $fecha_inicio.' '.$fecha_final,
        // );
        $ventas = array();
        $detallesVentas = array();
        foreach ( $rutas as $ruta ){
            array_push( $ventas , $ruta->facturasPorRuta($fecha_inicio,$fecha_final,$ruta->id) );
            array_push( $detallesVentas , $ruta->detallesPorRuta($fecha_inicio,$fecha_final,$ruta->id) );
        }
        $response = array(
            'rutas' => $rutas,
            'ventas' => $ventas,
            'detalles' => $detallesVentas,
        );
        return response()->json($response);
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
