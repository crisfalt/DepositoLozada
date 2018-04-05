<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoContenido;

class TipoContenidoController extends Controller
{
    //
    public function index() {
        $tiposContenidos = TipoContenido::orderBy('nombre') -> get();
        return view('admin.tipocontenido.index')->with(compact('tiposContenidos')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $tipoContenido = TipoContenido::find( $id );
        return view('admin.tipocontenido.show')->with(compact('tipoContenido'));
    }

    public function create() {
        return view('admin.tipocontenido.create');
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,TipoContenido::$rules,TipoContenido::$messages);
        //crear un prodcuto nuevo
        $tipoContenido = new TipoContenido();
        $tipoContenido -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $tipoContenido -> descripcion = $request->input('descripcion');
        $tipoContenido -> estado = $request->input('estado');
        $tipoContenido -> save(); //registrar producto
        $notification = 'Tipo de Contenido Agregado Exitosamente';
        return redirect('/tipocontenido') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $tipoContenido = TipoContenido::find( $id );
        return view('admin.tipocontenido.edit')->with(compact('tipoContenido')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,TipoContenido::$rules,TipoContenido::$messages);
        //crear un prodcuto nuevo
        $tipoContenido = TipoContenido::find( $id );
        $tipoContenido -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $tipoContenido -> descripcion = $request->input('descripcion');
        $tipoContenido -> estado = $request->input('estado');
        $tipoContenido -> save(); //registrar producto

        $notification = 'Tipo de Contenido ' . $request->input('nombre') . ' Actualizado Exitosamente';
        return redirect('/tipocontenido') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $tipoContenido = TipoContenido::find( $id );
        $tipoContenido -> delete(); //ELIMINAR
        $notification = 'Tipo de Contenido ' . $tipoContenido -> nombre . ' Eliminado Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
