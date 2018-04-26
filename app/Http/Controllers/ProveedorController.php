<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\TipoDocumento;

class ProveedorController extends Controller
{
    //
    public function index() {
        $proveedores = Proveedor::orderBy('name') -> get();
        return view('admin.proveedor.index')->with(compact('proveedores')); //listado de tipos movimientos
    }
    //
    public function create() {
        $tiposDocumento = TipoDocumento::orderBy('nombre') -> get();
        return view('admin.proveedor.register')->with( compact('tiposDocumento') );
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        if( $request->input('tipo_documento_id') == 'I' ) {
            $request['tipo_documento_id'] = null;
        }

        if( $request->input('celular') != "" ) {
            $this->validate($request,Proveedor::$rulesCelular);
        }
        else {
            if( $request->input('email') != "" ) {
                $this->validate($request,Proveedor::$rulesEmail);
            }
            else {
                $this->validate($request,Proveedor::$rules);
            }
        }
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        //crear un prodcuto nuevo
        $proveedor = new Proveedor();
        $proveedor -> number_id = $request->input('number_id');
        //$product -> description = $request->input('description');
        $proveedor -> name = $request->input('name');
        $proveedor -> tipo_documento_id = $request->input('tipo_documento_id');
        $proveedor -> phone = $request->input('phone');
        $proveedor -> celular = $request->input('celular');
        $proveedor -> address = $request->input('address');
        $proveedor -> email = $request->input('email');
        $proveedor -> estado = "A";
        $proveedor -> save(); //registrar producto
        $notification = 'Proveedor Registrado Exitosamente';
        return redirect('/proveedor') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        
        $notification = 'El proveedor aun no se elimina por cupla de kevin';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }

}
