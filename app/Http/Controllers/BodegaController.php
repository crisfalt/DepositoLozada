<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bodega;
use App\Municipio;

class BodegaController extends Controller
{
    //
    public function index() {
        $bodegas = Bodega::orderBy('nombre') -> get();
        return view('admin.bodega.index')->with(compact('bodegas')); //listado de tipos movimientos
    }

    //mostrar un tipo de movimiento
    public function show( $id ) {
        $tipoContenido = TipoContenido::find( $id );
        return view('admin.tipocontenido.show')->with(compact('tipoContenido'));
    }

    public function create() {
        //asi traemos la lista del atributo foraneo
        $municipios = Municipio::where( 'fk_departamento' , '41' ) ->orderBy('nombre') ->get();
        return view('admin.bodega.create')->with(compact('municipios'));
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        if( $request->input('fk_municipio') == 'I' ) {
            $request['fk_municipio'] = null;
        }
        if( $request->input('celular') == null ) {
            $request['celular'] = 0;
        }
        $this->validate($request,Bodega::$rules,Bodega::$messages);
        //crear un prodcuto nuevo
        $bodega = new Bodega();
        $bodega -> nombre = $request->input('nombre');
        //$product -> description = $request->input('description');
        $bodega -> direccion = $request->input('direccion');
        $bodega -> telefono = $request->input('telefono');
        $bodega -> celular = $request->input('celular');
        $bodega -> fk_municipio = $request->input('fk_municipio');
        $bodega -> save(); //registrar producto
        $notification = 'Bodega Agregada Exitosamente';
        return redirect('/bodega') -> with( compact( 'notification' ) );
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
        $bodega = Bodega::find( $id );
        $bodega -> delete(); //ELIMINAR
        $notification = 'Bodega' . $bodega -> nombre . ' Eliminada Exitosamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
