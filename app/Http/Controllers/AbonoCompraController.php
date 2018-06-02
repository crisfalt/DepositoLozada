<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\abonoCompra;
use App\compra;

class AbonoCompraController extends Controller
{
    public function searchTotal($saldocompra) {
        $valorescompra = compra::where( 'id', $saldocompra )->get();
        return response()->json($valorescompra);
    }
    public function index() {
        $abonoCompras = abonoCompra::orderBy('id','desc') -> get();
        return view('admin.abonocompra.index')->with(compact('abonoCompras')); //listado de abono
    }

   
    public function create() {
    	$compras = compra::orderBy('id','desc')->where('fk_forma_pago',2) -> get();
        return view('admin.abonocompra.create')->with(compact('compras'));
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,abonoCompra::$rules,abonoCompra::$messages);
        //crear un prodcuto nuevo
        $abonoCompras = new abonoCompra();
        $abonoCompras -> valor = $request->input('valor');        
        $abonoCompras -> fecha = $request->input('fecha');
        
        $saldo = floatval($request->input('saldo2'));

        $resultadoresta =$saldo - floatval(($abonoCompras -> valor));  
        

        $abonoCompras -> estado = $request->input('','A');
        $abonoCompras -> fk_compra = $request->input('fk_compra');
        //llamo el objeto de ventas para obtener sus valores
        $compra = compra::where('id',$abonoCompras -> fk_compra)->first();
        
        if($abonoCompras->valor >0)
        {

            if($abonoCompras->valor >$saldo)
            {

                $notification = 'el abono no puede ser mayor al saldo de la compra'; 
                return redirect('abonocompra/create') -> with( compact( 'notification' ) );
           
            }
            else
            {
                  

                 if($saldo==$abonoCompras -> valor)
                 {
                 

                 
                 $abonoCompras -> save();                 
                 $compra->fk_forma_pago = 1;
                 $compra->saldo = floatval($resultadoresta);
                 $compra->save();              
                 return redirect('abonocompra') -> with( compact( 'notification' )); 

                 }
                 else{
                
                
                 $abonoCompras -> save();
                 $compra->saldo = floatval($resultadoresta);
                 $compra->save(); 
                 
                 $notification = 'Abono Agregado Exitosamente a la compra'.$abonoCompras->fk_compra;
                 return redirect('abonocompra') -> with( compact( 'notification' ));
                 }

            }

        }
        else
        {
            $notification = 'el abono tiene que ser mayor 0'; 
            return redirect('abonocompra/create') -> with( compact( 'notification' ) );
        }

        
    }

  

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        // 
        $abonoCompra = abonoCompra::where('id',$id)->first();
        $compra = compra::where('id',$abonoCompra -> fk_compra)->first();

                if($compra->saldo==$compra->total&&$compra->fk_forma_pago==2)
                 {
                 

                                     
                $notification = 'este abono no se puede elimar  ' . $abonoCompra -> id . 'por favor contactar al desarrollador del software';    

                 return redirect('abonocompra') -> with( compact( 'notification' )); 

                 }


                if($compra->saldo==$abonoCompra -> valor&&$compra->fk_forma_pago==1)
                 {
                 

                 
                 $abonoCompra -> delete(); //ELIMINAR                
                 $compra->fk_forma_pago = 2;
                 $saldo = floatval($compra->saldo);
                 $resultadosuma =$saldo + $abonoCompra -> valor; 
                 $compra->saldo = floatval($resultadosuma);
                 $compra->save();                     
                $notification = 'este abono  ' . $abonoCompra -> id . ' se ha Eliminado Exitosamente y la compra a cambiado su estado por pagar';    

                 return redirect('abonocompra') -> with( compact( 'notification' )); 

                 }
                 else
                 {
                
                $abonoCompra -> delete();
                $compra->fk_forma_pago = 2;               
                $saldo = floatval($compra->saldo);
                $resultadosuma =$saldo + $abonoCompra -> valor; 
                $compra->saldo = floatval($resultadosuma);
                $compra->save();   
                 
                 
                $notification = 'este abono  ' . $abonoCompra -> id . ' se ha Eliminado Exitosamente';
                 return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
                 }
        
         //ELIMINAR
        
    }
}
