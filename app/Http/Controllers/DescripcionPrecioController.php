<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DescripcionPrecio;

class DescripcionPrecioController extends Controller
{
    //
    public function index() {
        $descripcionesPrecio = DescripcionPrecio::orderBy('nombre') -> get();
        return view('admin.descripcionprecio.index')->with(compact('descripcionesPrecio')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $descripcionPrecio = DescripcionPrecio::find( $id );
        return view('admin.descripcionprecio.show')->with(compact('descripcionPrecio'));
    }

    public function create() {
        return view('admin.descripcionprecio.create');
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,DescripcionPrecio::$rules,DescripcionPrecio::$messages);
        //crear un prodcuto nuevo
        $descripcionPrecio = new DescripcionPrecio();
        $descripcionPrecio -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $descripcionPrecio -> descripcion = $request->input('descripcion');
        $descripcionPrecio -> estado = $request->input('estado');
        $descripcionPrecio -> save(); //registrar producto
        $notification = 'descripcion precio Agregado Exitosamente';
        return redirect('/descripcionprecio') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $descripcionPrecio = DescripcionPrecio::find( $id );
        return view('admin.descripcionprecio.edit')->with(compact('descripcionPrecio')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,DescripcionPrecio::$rules,DescripcionPrecio::$messages);
        //crear un prodcuto nuevo
        $descripcionPrecio = DescripcionPrecio::find( $id );
        $descripcionPrecio -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $descripcionPrecio -> descripcion = $request->input('descripcion');
        $descripcionPrecio -> estado = $request->input('estado');
        $descripcionPrecio -> save(); //registrar producto

        $notification = 'descripcion precio ' . $request->input('nombre') . ' Actualizado Exitosamente';
        return redirect('/descripcionprecio') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $descripcionPrecio = DescripcionPrecio::find( $id );
        $descripcionPrecio -> delete(); //ELIMINAR
        $notification = 'descripcion precio ' . $descripcionPrecio -> nombre . ' Eliminado Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
