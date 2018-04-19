<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ruta;
use App\Zona;

class RutaController extends Controller
{
    //
    public function index( $id ) {
        $zona = Zona::find($id);
        $rutas = $zona -> rutas() -> orderBy('nombre') -> get();
        return view('admin.ruta.index')->with(compact('zona','rutas')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $ruta = Ruta::find( $id );
        return view('admin.ruta.show')->with(compact('ruta'));
    }

    public function create( $id ) {
        $zona = Zona::find( $id );
        return view('admin.ruta.create')->with( compact( 'zona' ) );
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,Ruta::$rules,Ruta::$messages);
        // dd( $request->input('zona_id') );
        //crear un prodcuto nuevo
        $ruta = new ruta();
        $ruta -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $ruta -> descripcion = $request->input('descripcion');
        $ruta -> estado = $request->input('estado');
        $ruta -> zona_id = $request->input('zona_id');
        $ruta -> save(); //registrar producto
        $notification = 'ruta Agregada Exitosamente';
        return redirect('/zona/'.$request->input('zona_id').'/rutas') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $ruta = Ruta::find( $id );
        return view('admin.ruta.edit')->with(compact('ruta')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,Ruta::$rules,Ruta::$messages);
        //crear un prodcuto nuevo
        $ruta = Ruta::find( $id );
        $ruta -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $ruta -> descripcion = $request->input('descripcion');
        $ruta -> zona_id = $request->input('zona_id');
        $ruta -> estado = $request->input('estado');
        $ruta -> save(); //registrar producto

        $notification = 'Ruta ' . $request->input('nombre') . ' Actualizada Exitosamente';
        return redirect('/zona/'.$request->input('zona_id').'/rutas') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $ruta = Ruta::find( $id );
        $ruta -> delete(); //ELIMINAR
        $notification = 'Ruta ' . $ruta -> nombre . ' Eliminada Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
