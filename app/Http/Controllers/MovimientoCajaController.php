<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MovimientoCaja;

class MovimientoCajaController extends Controller
{
    //
    public function index() {
        $movimientosCaja = MovimientoCaja::orderBy('id','desc')->get();
        return view('caja.movimientocaja.index')->with(compact('movimientosCaja')); //listado de tipos movimientos
    }

    public function imprimir($id)
    {
       
       
                
        $Cargarmovimientos = MovimientoCaja::where('id',$id)->get();          
        
         
       
    
      
        $view=view('caja.movimientocaja.recibo',compact('Cargarmovimientos'));
        $pdf=\App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream();
      }
}
