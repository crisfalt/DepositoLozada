<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstadoDeVenta;

class EstadoVentaController extends Controller
{
    
    public function index() {
        // dd("paco");
        $estadosVentas = EstadoDeVenta::orderBy('nombre') -> get();
        // dd(count($estadosVentas));
        return view('admin.estadoventa.index')->with(compact('estadosVentas')); //listado de tipos movimientos
    }

    //mostrar un tipo de datos
    public function show( $id ) {
        $estadosVentas = EstadoDeVenta::find( $id );
        return view('admin.estadoventa.show')->with(compact('estadosVentas'));
    }

    public function create() {
        return view('admin.estadoventa.create');
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,EstadoDeVenta::$rules,EstadoDeVenta::$messages);
        //crear un prodcuto nuevo
        $estadoVenta = new EstadoDeVenta();
        $estadoVenta -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $estadoVenta -> descripcion = $request->input('descripcion');
        $estadoVenta -> estado = $request->input('estado');
        $estadoVenta -> save(); //registrar producto
        $notification = 'Estado de Venta Agregado Exitosamente';
        return redirect('/estadoventa') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $estadosVentas = EstadoDeVenta::find( $id );
        return view('admin.estadoventa.edit')->with(compact('estadosVentas')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,EstadoDeVenta::$rules,EstadoDeVenta::$messages);
        //crear un prodcuto nuevo
        $estadosVentas = EstadoDeVenta::find( $id );
        $estadosVentas -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $estadosVentas -> descripcion = $request->input('descripcion');
        $estadosVentas -> estado = $request->input('estado');
        $estadosVentas -> save(); //registrar estadovena

        $notification = 'Estado de Venta ' . $request->input('nombre') . ' Actualizado Exitosamente';
        return redirect('/estadoventa') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $estadosVentas = EstadoDeVenta::find( $id );
        $estadosVentas -> delete(); //ELIMINAR
        $notification = 'Estado de Venta ' . $estadosVentas -> nombre . ' Eliminado Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }
}
