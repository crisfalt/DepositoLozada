<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FormaPago;

class FormaPagoController extends Controller
{
    public function index() {
        $formaPagos = FormaPago::orderBy('nombre') -> get();
        return view('admin.formapago.index')->with(compact('formaPagos')); //listado de formapago
    }

    // mostrar un tipo de movimiento
    public function show( $id ) {
        $formaPagos = FormaPago::find( $id );
        return view('admin.formapago.show')->with(compact('formaPagos'));
    }

    public function create() {
        return view('admin.formapago.create');
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de formapago
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,FormaPago::$rules,formapago::$messages);
        //crear un prodcuto nuevo
        $formaPagos = new FormaPago();
        $formaPagos -> nombre = $request->input('nombre');        
        $formaPagos -> descripcion = $request->input('descripcion');
        $formaPagos -> estado = $request->input('estado');
        $formaPagos -> save(); //registrar formapago
        $notification = 'Forma de Pago Agregado Exitosamente';
        return redirect('formapago') -> with( compact( 'formaPagos' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para formapago con id $id";
        $formaPagos = FormaPago::find( $id );
        return view('admin.formapago.edit')->with(compact('formaPagos')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un forma de pago
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,FormaPago::$rules,formapago::$messages);
        //crear un prodcuto nuevo
        $formaPagos = FormaPago::find( $id );
        $formaPagos -> nombre = $request->input('nombre');     
        $formaPagos -> descripcion = $request->input('descripcion');
        $formaPagos -> estado = $request->input('estado');
        $formaPagos -> save(); //registrar forma pago

        $notification = 'Forma de pago' .$request->input('nombre'). ' Actualizado Exitosamente';
        return redirect('formapago') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $formaPagos = FormaPago::find( $id );
        $formaPagos -> delete(); //ELIMINAR
        $notification = 'Forma Pago' . $formaPagos -> nombre . ' Eliminado Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }
}
