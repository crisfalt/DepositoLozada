<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perfil;

class PerfilController extends Controller
{
    //
    public function index() {
        $perfiles = Perfil::orderBy('nombre') -> get();
        return view('admin.perfil.index')->with(compact('perfiles')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $perfil = Perfil::find( $id );
        return view('admin.perfil.show')->with(compact('perfil'));
    }

    public function create() {
        return view('admin.perfil.create');
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $reglas = Perfil::$rules; //reglas a mi antojo y personalizadas
        if( $request->input('nombre') != "" ) {
            $reglas['nombre'] .= '|unique:perfils,nombre';
        }
        $this->validate($request,$reglas,Perfil::$messages);
        //crear un prodcuto nuevo
        $perfil = new Perfil();
        $perfil -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $perfil -> descripcion = $request->input('descripcion');
        $perfil -> estado = $request->input('estado');
        $perfil -> save(); //registrar producto
        $notification = 'perfil Agregada Exitosamente';
        return redirect('/perfil') -> with( compact( 'notification' ) );
    }

    public function edit( $id ) {
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $perfil = Perfil::find( $id );
        return view('admin.perfil.edit')->with(compact('perfil')); //formulario de registro
    }

    public function update( Request $request , $id ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,Perfil::$rules,Perfil::$messages);
        //crear un prodcuto nuevo
        $perfil = Perfil::find( $id );
        $perfil -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $perfil -> descripcion = $request->input('descripcion');
        $perfil -> estado = $request->input('estado');
        $perfil -> save(); //registrar producto

        $notification = 'perfil ' . $request->input('nombre') . ' Actualizada Exitosamente';
        return redirect('/perfil') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        // dd( $request -> input( 'idDelte' ) );
        //$categories = Category::all(); //traer categorias
        // return "Mostrar aqui formulario para producto con id $id";
        $perfil = Perfil::find( $id );
        $perfil -> delete(); //ELIMINAR
        $notification = 'perfil ' . $perfil -> nombre . ' Eliminada Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
