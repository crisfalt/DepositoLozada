<?php
/**
 * Created by PhpStorm.
 * User: crisfalt
 * Date: 14/08/2018
 * Time: 11:17 PM
 */

namespace App\Http\Controllers\Vendedor;

use App\Http\Controllers\Controller;
use App\Cliente;
use Illuminate\Http\Request;
use App\Ruta;
use App\Zona;
use App\DiasRutas;
use Carbon\Carbon;

class RutaController extends Controller
{

    public function rutasVendedorPorDia( $idVendedor ) {
        setlocale(LC_ALL,"es_CO");
        $diaSemana = strftime("%A");
//        $rutasHoy = DiasRutas::where( 'dia', '=', ucfirst($diaSemana) )->with('rutas');
        $rutasHoy = Ruta::
                    join( 'dias_rutas', 'dias_rutas.ruta_id','=','rutas.id' )
                    ->where('dias_rutas.dia','=', ucfirst( $diaSemana ) )
                    ->orderBy( 'rutas.id' )
                    ->get();
        return view( 'vendedor.ruta.index' )->with( compact( 'rutasHoy' ) );
    }

    //cargar el mapa de una ruta
    public function loadMap( $id ) {
        $ruta = Ruta::find($id);
//         dd( $ruta -> clientes() );
        return view('vendedor.ruta.map')->with(compact('ruta') );
    }

}