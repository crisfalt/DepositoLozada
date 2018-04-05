<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SizeBotella;

class SizeBotellaController extends Controller
{
    //
    public function index() {
        $sizesBotellas = SizeBotella::orderBy('nombre') -> get();
        return view('admin.sizebotella.index')->with(compact('sizesBotellas')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $sizeBotella = SizeBotella::find( $id );
        return view('admin.sizebotella.show')->with(compact('sizeBotella'));
    }

    public function create() {
        return view('admin.sizebotella.create');
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,SizeBotella::$rules,SizeBotella::$messages);
        //crear un prodcuto nuevo
        $sizeBotella = new SizeBotella();
        $sizeBotella -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $sizeBotella -> descripcion = $request->input('descripcion');
        $sizeBotella -> estado = $request->input('estado');
        $sizeBotella -> save(); //registrar producto
        $notification = 'Tamaño de Envase Agregado Exitosamente';
        return redirect('/sizebotella') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $sizeBotella = SizeBotella::find( $id );
        return view('admin.sizebotella.edit')->with(compact('sizeBotella')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,SizeBotella::$rules,SizeBotella::$messages);
        //crear un prodcuto nuevo
        $sizeBotella = SizeBotella::find( $id );
        $sizeBotella -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $sizeBotella -> descripcion = $request->input('descripcion');
        $sizeBotella -> estado = $request->input('estado');
        $sizeBotella -> save(); //registrar producto

        $notification = 'Tamaño Envase ' . $request->input('nombre') . ' Actualizado Exitosamente';
        return redirect('/sizebotella') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $sizeBotella = SizeBotella::find( $id );
        $sizeBotella -> delete(); //ELIMINAR
        $notification = 'Tamaño Envase ' . $sizeBotella -> nombre . ' Eliminado Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }
}
