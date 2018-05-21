<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstadoCompra;

class EstadoCompraController extends Controller
{
    public function index() {
        $estadoCompras = EstadoCompra::orderBy('nombre') -> get();
        return view('admin.estadocompra.index')->with(compact('estadoCompras')); //listado de estadoscompra
    }

    // mostrar un tipo de movimiento
    public function show( $id ) {
        $estadoCompras = EstadoCompra::find( $id );
        return view('admin.estadocompra.show')->with(compact('estadoCompras'));
    }

    public function create() {
        return view('admin.estadocompra.create');
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,EstadoCompra::$rules,EstadoCompra::$messages);
        //crear un prodcuto nuevo
        $estadoCompras = new EstadoCompra();
        $estadoCompras -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $estadoCompras -> descripcion = $request->input('descripcion');
        $estadoCompras -> estado = $request->input('estado');
        $estadoCompras -> save(); //registrar producto
        $notification = 'Estado Compra Agregado Exitosamente';
        return redirect('estadocompra') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $estadoCompras = EstadoCompra::find( $id );
        return view('admin.estadocompra.edit')->with(compact('estadoCompras')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,EstadoCompra::$rules,EstadoCompra::$messages);
        //crear un prodcuto nuevo
        $estadoCompras = EstadoCompra::find( $id );
        $estadoCompras -> nombre = $request->input('nombre');     
        $estadoCompras -> descripcion = $request->input('descripcion');
        $estadoCompras -> estado = $request->input('estado');
        $estadoCompras -> save(); //registrar estado

        $notification = 'Estado de compra ' . $request->input('nombre') . ' Actualizado Exitosamente';
        return redirect('/estadocompra') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $estadoCompras = EstadoCompra::find( $id );
        $estadoCompras -> delete(); //ELIMINAR
        $notification = 'Estado de Compra ' . $estadoCompras -> nombre . ' Eliminado Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }
}
