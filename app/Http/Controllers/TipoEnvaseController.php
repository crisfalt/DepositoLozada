<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoEnvase;

class TipoEnvaseController extends Controller
{
    //
    public function index() {
        $tiposEnvases = TipoEnvase::orderBy('nombre') -> get();
        return view('admin.tipoenvase.index')->with(compact('tiposEnvases')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $tipoEnvase = TipoEnvase::find( $id );
        return view('admin.tipoenvase.show')->with(compact('tipoEnvase'));
    }

    public function create() {
        return view('admin.tipoenvase.create');
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,TipoEnvase::$rules,TipoEnvase::$messages);
        //crear un prodcuto nuevo
        $tipoEnvase = new TipoEnvase();
        $tipoEnvase -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $tipoEnvase -> descripcion = $request->input('descripcion');
        $tipoEnvase -> estado = $request->input('estado');
        $tipoEnvase -> save(); //registrar producto
        $notification = 'Tipo de Envase Agregado Exitosamente';
        return redirect('/tipoenvase') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $tipoEnvase = TipoEnvase::find( $id );
        return view('admin.tipoenvase.edit')->with(compact('tipoEnvase')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,TipoEnvase::$rules,TipoEnvase::$messages);
        //crear un prodcuto nuevo
        $tipoEnvase = TipoEnvase::find( $id );
        $tipoEnvase -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $tipoEnvase -> descripcion = $request->input('descripcion');
        $tipoEnvase -> estado = $request->input('estado');
        $tipoEnvase -> save(); //registrar producto

        $notification = 'Tipo de Envase ' . $request->input('nombre') . ' Actualizado Exitosamente';
        return redirect('/tipoenvase') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $tipoEnvase = TipoEnvase::find( $id );
        $tipoEnvase -> delete(); //ELIMINAR
        $notification = 'Tipo de Envase ' . $tipoEnvase -> nombre . ' Eliminado Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
