<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venta;

class CarteraController extends Controller
{
    public function index() {
        $facTuras = Venta::orderBy('id')->where('fk_forma_de_pago',2) -> get();
        return view('admin.cartera.index')->with(compact('facTuras')); //listado de formapago
    }
    public function searchVentas($idcedula) {
        $consulta = Venta::where('fk_cliente', $idcedula)->get();
            
        if( count($consulta)>0 )
        {
        $vectorresponder = ['status' => true , 'msg' => 'cliente encontrado','consulta'=>$consulta];
        }
        else
        {
         $vectorresponder = ['status' => false , 'msg' => 'cliente no encontrado'];
        }
		
		return response()->json($vectorresponder);
    }
    
    // public function searchSaldo($idcedula) {
	// 	$consulta2 = Venta::where( 'fk_cliente', $idcedula )->where('fk_forma_de_pago',2)->get();
	// 	// Log($consulta);
	// 	// dd($consulta);
	// 	return response()->json($consulta);
	// }
}
