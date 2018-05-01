<?php

namespace App\Http\Controllers\Vendedor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Producto;

class ProductoController extends Controller
{
    //
    public function index() {
        $Productos = Producto::orderBy('nombre') -> get();
        return view('vendedor.producto.index')->with(compact('Productos')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $Producto = Producto::where( 'codigo' , $id ) -> first();
        // $Imagenes = ImagenesProducto::where('fk_producto',$Producto->codigo) -> orderBy('featured','desc') -> get(); //para mostrar las imagenes ordenadas por las destacada
        return view('vendedor.producto.show')->with(compact('Producto'));
    }

}
