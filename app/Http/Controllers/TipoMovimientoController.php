<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoMovimiento;

class TipoMovimientoController extends Controller
{
    //
    public function index() {
        $tiposMovimiento = TipoMovimiento::orderBy('nombre') -> get();
        return view('admin.tipomovimiento.index')->with(compact('tiposMovimiento')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $tipoMovimiento = TipoMovimiento::find( $id );
        return view('admin.tipomovimiento.show')->with(compact('tipoMovimiento'));
    }

    public function create() {
        return view('admin.tipomovimiento.create');
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,TipoMovimiento::$rules,TipoMovimiento::$messages);
        //crear un prodcuto nuevo
        $tipoMovimiento = new TipoMovimiento();
        $tipoMovimiento -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $tipoMovimiento -> descripcion = $request->input('descripcion');
        $tipoMovimiento -> estado = $request->input('estado');
        $tipoMovimiento -> save(); //registrar producto
        $notification = 'Tipo Movimiento Agregado Exitosamente';
        return redirect('/tipomovimiento') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $tipoMovimiento = TipoMovimiento::find( $id );
        return view('admin.tipomovimiento.edit')->with(compact('tipoMovimiento')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,TipoMovimiento::$rules,TipoMovimiento::$messages);
        //crear un prodcuto nuevo
        $tipoMovimiento = TipoMovimiento::find( $id );
        $tipoMovimiento -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $tipoMovimiento -> descripcion = $request->input('descripcion');
        $tipoMovimiento -> estado = $request->input('estado');
        $tipoMovimiento -> save(); //registrar producto

        $notification = 'Tipo Movimiento ' . $request->input('nombre') . ' Actualizado Exitosamente';
        return redirect('/tipomovimiento') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $tipoMovimiento = TipoMovimiento::find( $id );
        $tipoMovimiento -> delete(); //ELIMINAR
        $notification = 'Tipo de Movimiento ' . $tipoMovimiento -> nombre . ' Eliminado Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
