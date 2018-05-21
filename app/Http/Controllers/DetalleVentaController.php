<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\detalles_venta;
use Session;


use Illuminate\Http\Request;

class DetalleVentaController extends Controller
{
    public function destroy( $id,$numero_canasta) {
        $idVenta=Session::get('IdVenta');

        $detalleVentas=DB::table('detalles_ventas')->where('fk_factura',$idVenta )->where('Numero_canasta',$numero_canasta)->get();
      
        if( count($detalleVentas) !=0)
    {
        
        foreach($detalleVentas as $detalleVenta)
        {
           $IdDetallesVenta= $detalleVenta->id;
            $DetalleVenta = detalles_venta::find($IdDetallesVenta);
            $DetalleVenta -> delete();

        }
        $notification = 'la canasta #' . $numero_canasta . ' Eliminado Exitosamente';
        
    }
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
    else
    {
        $detalle_ventas = detalles_venta::find( $id );
        $detalle_ventas -> delete(); //ELIMINAR
        $notification = '' . $detalle_ventas -> nombre . ' Eliminado Exitosamente';
    }
        
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }
    public function destroyEdit( $id,$numero_canasta) {
        $idVenta=Session::get('IdVentaEditar');

        $detalleVentas=DB::table('detalles_ventas')->where('fk_factura',$idVenta )->where('Numero_canasta',$numero_canasta)->get();
      
        if( count($detalleVentas) !=0)
    {
        
        foreach($detalleVentas as $detalleVenta)
        {
           $IdDetallesVenta= $detalleVenta->id;
            $DetalleVenta = detalles_venta::find($IdDetallesVenta);
            $DetalleVenta -> delete();

        }
        $notification = 'la canasta #' . $numero_canasta . ' Eliminado Exitosamente';
        
    }
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
    else
    {
        $detalle_ventas = detalles_venta::find( $id );
        $detalle_ventas -> delete(); //ELIMINAR
        $notification = '' . $detalle_ventas -> nombre . ' Eliminado Exitosamente';
    }
        
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }
}
