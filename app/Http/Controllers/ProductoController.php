<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Marca;
use App\SizeBotella;
use App\TipoEnvase;
use App\TipoContenido;
use App\TipoPaca;
use App\Bodega;

class ProductoController extends Controller
{
    //
    public function index() {
        $Productos = Producto::orderBy('nombre') -> get();
        return view('admin.producto.index')->with(compact('Productos')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $marca = Marca::find( $id );
        return view('admin.producto.show')->with(compact('marca'));
    }

    public function create() {
        $marcas = Marca::orderBy('nombre') -> get();
        $sizes = SizeBotella::orderBy('nombre') -> get();
        $tiposEnvase = TipoEnvase::orderBy('nombre') -> get();
        $tiposContenido = TipoContenido::orderBy('nombre') -> get();
        $tiposPaca = TipoPaca::orderBy('nombre') -> get();
        $bodegas = Bodega::orderBy('nombre') -> get();
        return view('admin.producto.create')->with(compact('marcas','sizes','tiposEnvase','tiposContenido','tiposPaca','bodegas'));
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        if( $request->input('fk_marca') == 'I' ) {
            $request['fk_marca'] = null;
        }
        if( $request->input('fk_size') == 'I' ) {
            $request['fk_size'] = null;
        }
        if( $request->input('fk_tipo_envase') == 'I' ) {
            $request['fk_tipo_envase'] = null;
        }
        if( $request->input('fk_tipo_contenido') == 'I' ) {
            $request['fk_tipo_contenido'] = null;
        }
        if( $request->input('fk_tipo_paca') == 'I' ) {
            $request['fk_tipo_paca'] = null;
        }
        if( $request->input('fk_bodega') == 'I' ) {
            $request['fk_bodega'] = null;
        }
        if( $request->input('cantidad') == null ) {
            $request['cantidad'] = 0;
        }
        $this->validate($request,Producto::$rules,Producto::$messages);
        //crear un prodcuto nuevo
        $producto = new Producto();
        $producto -> codigo = $request->input('codigo');
        $producto -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $producto -> descripcion = $request->input('descripcion');
        $producto -> cantidad = $request->input('cantidad');
        $producto -> cantidad_reserva = $request->input('cantidad_reserva');
        $producto -> precio_compra = $request->input('precio_compra');
        $producto -> fk_marca = $request->input('fk_marca');
        $producto -> fk_size = $request->input('fk_size');
        $producto -> fk_tipo_envase = $request->input('fk_tipo_envase');
        $producto -> fk_tipo_contenido = $request->input('fk_tipo_contenido');
        $producto -> fk_tipo_paca = $request->input('fk_tipo_paca');
        $producto -> fk_bodega = $request->input('fk_bodega');
        $producto -> estado = $request->input('estado');
        $producto -> save(); //registrar producto
        $notification = 'Producto Agregado Exitosamente';
        return redirect('/producto') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $marca = Marca::find( $id );
        return view('admin.producto.edit')->with(compact('marca')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,Marca::$rules,Marca::$messages);
        //crear un prodcuto nuevo
        $marca = Marca::find( $id );
        $marca -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $marca -> descripcion = $request->input('descripcion');
        $marca -> estado = $request->input('estado');
        $marca -> save(); //registrar producto

        $notification = 'Marca ' . $request->input('nombre') . ' Actualizada Exitosamente';
        return redirect('/producto') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $marca = Marca::find( $id );
        $marca -> delete(); //ELIMINAR
        $notification = 'El producto ' . $marca -> nombre . ' Eliminada Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
