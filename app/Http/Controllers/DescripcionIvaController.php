<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DescripcionIva;

class DescripcionIvaController extends Controller
{
    //
    public function index() {
        $descripcionesIva = DescripcionIva::orderBy('nombre') -> get();
        return view('admin.descripcioniva.index')->with(compact('descripcionesIva')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $descripcionIva = DescripcionIva::find( $id );
        return view('admin.descripcioniva.show')->with(compact('descripcionIva'));
    }

    public function create() {
        return view('admin.descripcioniva.create');
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,DescripcionIva::$rules,DescripcionIva::$messages);
        //crear un prodcuto nuevo
        $descripcionIva = new DescripcionIva();
        $descripcionIva -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $descripcionIva -> descripcion = $request->input('descripcion');
        $descripcionIva -> estado = $request->input('estado');
        $descripcionIva -> save(); //registrar producto
        $notification = 'descripcion Iva Agregado Exitosamente';
        return redirect('/descripcioniva') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $descripcionIva = DescripcionIva::find( $id );
        return view('admin.descripcioniva.edit')->with(compact('descripcionIva')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,DescripcionIva::$rules,DescripcionIva::$messages);
        //crear un prodcuto nuevo
        $descripcionIva = DescripcionIva::find( $id );
        $descripcionIva -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $descripcionIva -> descripcion = $request->input('descripcion');
        $descripcionIva -> estado = $request->input('estado');
        $descripcionIva -> save(); //registrar producto

        $notification = 'descripcion Iva ' . $request->input('nombre') . ' Actualizado Exitosamente';
        return redirect('/descripcioniva') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $descripcionIva = DescripcionIva::find( $id );
        $descripcionIva -> delete(); //ELIMINAR
        $notification = 'descripcion Iva ' . $descripcionIva -> nombre . ' Eliminado Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
