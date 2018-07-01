<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\abonoVenta;
use App\Venta;

class AbonoController extends Controller
{
    public function searchTotal($saldoventa) {
        $valoresventa = Venta::where( 'id', $saldoventa )->get();
        return response()->json($valoresventa);
    }
    public function index() {
        $abonoVentas = abonoVenta::orderBy('id','desc') -> get();
        return view('admin.abonoventa.index')->with(compact('abonoVentas')); //listado de abono
    }


    public function create($IdAbono="") {

    //    $ventas = Venta::orderBy('id','desc')->where('fk_forma_de_pago',2) -> get();


        if($IdAbono == 0)
        {
        $ventas = Venta::orderBy('id','desc')->where('fk_forma_de_pago',2) -> get();
        }
        else{
        $ventas = Venta::orderBy('id','desc')->where('fk_forma_de_pago',2)->where('id',$IdAbono)-> get();
        }
        return view('admin.abonoventa.create')->with(compact('ventas','IdAbono'));
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,abonoVenta::$rules,abonoVenta::$messages);
        //crear un prodcuto nuevo
        $abonoVentas = new abonoVenta();
        $abonoVentas -> valor = $request->input('valor');        
        $abonoVentas -> fecha = $request->input('fecha');
        
        $saldo = floatval($request->input('saldo2'));

        $resultadoresta =$saldo - floatval(($abonoVentas -> valor));  
        

        $abonoVentas -> estado = $request->input('','A');
        $abonoVentas -> fk_venta = $request->input('fk_venta');
        //llamo el objeto de ventas para obtener sus valores
        $venta = Venta::where('id',$abonoVentas -> fk_venta)->first();
        
        if($abonoVentas->valor >0)
        {

            if($abonoVentas->valor >$saldo)
            {

                $notification = 'el abono no puede ser mayor al saldo de la factura'; 
                return redirect('abono/create') -> with( compact( 'notification' ) );
           
            }
            else
            {
                  

                 if($saldo==$abonoVentas -> valor)
                 {
                 

                 
                 $abonoVentas -> save();                 
                 $venta->fk_forma_de_pago = 1;
                 $venta->saldo = floatval($resultadoresta);
                 $venta->save();              
                 return redirect('abono') -> with( compact( 'notification' )); 

                 }
                 else{
                
                
                 $abonoVentas -> save();
                 $venta->saldo = floatval($resultadoresta);
                 $venta->save(); 
                 
                 $notification = 'Abono Agregado Exitosamente a la factura'.$abonoVentas->fk_venta;
                 return redirect('abono') -> with( compact( 'notification' ));
                 }

            }

        }
        else
        {
            $notification = 'el abono tiene que ser mayor 0'; 
            return redirect('abono/create') -> with( compact( 'notification' ) );
        }

        
    }

  

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        // 
        $abonoVentas = abonoVenta::where('id',$id)->first();
        $venta = Venta::where('id',$abonoVentas -> fk_venta)->first();

                if($venta->saldo==$venta->total&&$venta->fk_forma_de_pago==2)
                 {
                 

                                     
                $notification = 'este abono no se puede elimar  ' . $abonoVentas -> id . 'por favor contactar al desarrollador del software';    

                 return redirect('abono') -> with( compact( 'notification' )); 

                 }


                if($venta->saldo==$abonoVentas -> valor&&$venta->fk_forma_de_pago==1)
                 {
                 

                 
                 $abonoVentas -> delete(); //ELIMINAR                
                 $venta->fk_forma_de_pago = 2;
                 $saldo = floatval($venta->saldo);
                 $resultadosuma =$saldo + $abonoVentas -> valor; 
                 $venta->saldo = floatval($resultadosuma);
                 $venta->save();                     
                $notification = 'este abono  ' . $abonoVentas -> id . ' se ha Eliminado Exitosamente y la factura a cambiado su estado por pagar';    

                 return redirect('abono') -> with( compact( 'notification' )); 

                 }
                 else
                 {
                
                $abonoVentas -> delete();
                $venta->fk_forma_de_pago = 2;               
                $saldo = floatval($venta->saldo);
                $resultadosuma =$saldo + $abonoVentas -> valor; 
                $venta->saldo = floatval($resultadosuma);
                $venta->save();   
                 
                 
                $notification = 'este abono  ' . $abonoVentas -> id . ' se ha Eliminado Exitosamente';
                 return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
                 }
        
         //ELIMINAR
        
    }
}
