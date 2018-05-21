<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  App\detalle_compra;
use Session;

class DetalleCompraController extends Controller
{
    public function store(Request $request)
    {
    	$detalleCompras= new DetalleCompra();
    	$detalleCompras->fk_compra = $request->compras->id;
    	$detalleCompras->fk_producto = $request->fk_producto;
    	$detalleCompras->cantidad= $request->cantidad;
    	$detalleCompras->precio= $request->precio;

    	$detalleCompras->save();


    	$notification='El producto se ha Agregado a la compras corretamente.';
        return back()->with(compact('notification'));

    }

  public function destroy( $id,$numero_canasta) {
        $idCompra=Session::get('IdCompra');

        $detalleCompras=DB::table('detalle_compras')->where('fk_compra',$idCompra )->where('Numero_canasta',$numero_canasta)->get();
      
        if( count($detalleCompras) !=0)
    {
        
        foreach($detalleCompras as $detalleCompra)
        {
           $IdDetallesVenta= $detalleCompra->id;
            $DetalleCompra = detalle_compra::find($IdDetallesVenta);
            $DetalleCompra -> delete();

        }
        $notification = 'la canasta #' . $numero_canasta . ' Eliminado Exitosamente';
        
    }
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
    else
    {
        $detalle_compras = detalle_compra::find( $id );
        $detalle_compras -> delete(); //ELIMINAR
        $notification = '' . $detalle_compras -> nombre . ' Eliminado Exitosamente';
    }
        
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

    public function destroyEdit( $id,$numero_canasta) {
        $idCompra=Session::get('IdCompraEditar');
    

        $detalleCompras=DB::table('detalle_compras')->where('fk_compra',$idCompra )->where('Numero_canasta',$numero_canasta)->get();
      
        if( count($detalleCompras) !=0)
    {
        
        foreach($detalleCompras as $detalleCompra)
        {
           $IdDetallesCompra= $detalleCompra->id;
            $DetalleCompra = detalle_compra::find($IdDetallesCompra);
            $DetalleCompra -> delete();

        }
        $notification = 'la canasta #' . $numero_canasta . ' Eliminado Exitosamente';
        
    }
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
    else
    {
        $detalle_compras = detalle_compra::find( $id );
        $detalle_compras -> delete(); //ELIMINAR
        $notification = '' . $detalle_compras -> nombre . ' Eliminado Exitosamente';
    }
        
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
