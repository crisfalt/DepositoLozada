<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Proveedor;
use App\Producto;
use App\compra;
use App\DetalleCompra;
use App\detalle_compra;

use Session;

class SearchController extends Controller
{
    // public function show(Request $request)
    // {
    // 	$query=$request->input('proveedor');
    // 	$proveedors=Proveedor::where('nombre','like',"%$query%")->pagiante(6);
    // 	return view('search.show')->with(compact('proveedors','query'));
    // }
    // 
    
       public function dataCliente()
    {

        $proveedorsNombre= Proveedor::pluck('nombre');
   
        return $proveedors;
        
    }
    
     public function dataProveedor()
    {

        $proveedorsNombre= Proveedor::pluck('nombre');
   
    	return $proveedors;
    	
    }

    public function precio( $id ) {
    	$producto = Producto::where('nombre',$id)->first();
    	return $producto -> precio_compra;
    }

    public function data2()
    {
    	$productos= Producto::pluck('nombre');
        //$MostrarPrecio= Producto::where('nombre',productos).first('precio_venta');
        
    	return $productos;
    	
    }

     public function AgregarCompra( Request $request )
    {
 
        $detalle_compra = new detalle_compra();
         if( $request->input('cantidad') == null ) {
            $request['cantidad'] = 0;
           }
           
        //    $this->validate($request,detalle_compra::$rules,detalle_compra::$messages);
        
        $idCompra=$request->session()->get('IdCompra');
        $request['fk_compra']= $idCompra;
        $ObtenerIdProdcuto=explode(',',$request->input('fk_producto'));
        // dd($ObtenerIdProdcuto[1]);
       
        $request['fk_producto']=$ObtenerIdProdcuto[0];
        // $request['precio']=$ObtenerIdProdcuto[1];

       
        
       


        $detalle_compra -> fk_producto = $request->input('fk_producto');
        $detalle_compra -> fk_compra = $request->input('fk_compra');
        $detalle_compra -> precio = $request->input('precio_compra');
        $detalle_compra -> cantidad = $request->input('cantidad');
       
        $IdCompra= session::get('IdCompra');
        $ConsultarIDProducto = DB::table('detalle_compras')->where('fk_producto',$ObtenerIdProdcuto[0])->where('fk_compra', $IdCompra)->first();
                
        if(count($ConsultarIDProducto) != 0)
         {
            DB::table('detalle_compras')
            ->where('fk_producto',$ObtenerIdProdcuto[0])
            ->where('fk_compra',$IdCompra)
            ->update(['cantidad' => (int)$ConsultarIDProducto-> cantidad + (int)$request->input('cantidad')]);
        }
        else{

            $detalle_compra -> save();
        }
       
         //registrar Pre detalle de compra
       
        $notification = 'se agrego exitosamente';

  
      
        return redirect('/compra/create') -> with( compact( 'detalle_compra' ) );
        
    }


    public function AgregarCompraEditar( Request $request )
    {
 
        $detalle_compra = new detalle_compra();
         if( $request->input('cantidad') == null ) {
            $request['cantidad'] = 0;
           }
           
        //    $this->validate($request,detalle_compra::$rules,detalle_compra::$messages);
        
        $idCompra=$request->session()->get('IdCompraEditar');
        $request['fk_compra']= $idCompra;
        $ObtenerIdProdcuto=explode(',',$request->input('fk_producto'));
        // dd($ObtenerIdProdcuto[1]);
       
        $request['fk_producto']=$ObtenerIdProdcuto[0];
        // $request['precio']=$ObtenerIdProdcuto[1];

       
        
       


        $detalle_compra -> fk_producto = $request->input('fk_producto');
        $detalle_compra -> fk_compra = $request->input('fk_compra');
        $detalle_compra -> precio = $request->input('precio_compra');
        $detalle_compra -> cantidad = $request->input('cantidad');
       
        $IdCompra= session::get('IdCompraEditar');
        $ConsultarIDProducto = DB::table('detalle_compras')->where('fk_producto',$ObtenerIdProdcuto[0])->where('fk_compra', $IdCompra)->first();
                
        if(count($ConsultarIDProducto) != 0)
         {
            DB::table('detalle_compras')
            ->where('fk_producto',$ObtenerIdProdcuto[0])
            ->where('fk_compra',$IdCompra)
            ->update(['cantidad' => (int)$ConsultarIDProducto-> cantidad + (int)$request->input('cantidad')]);
        }
        else{

            $detalle_compra -> save();
        }
       
         //registrar Pre detalle de compra
       
        $notification = 'se agrego exitosamente';


      
        return redirect('/compra/'.$idCompra.'/edit/') -> with( compact( 'detalle_compra' ) );
        
    }
}
