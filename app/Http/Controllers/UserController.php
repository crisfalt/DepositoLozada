<?php

namespace App\Http\Controllers;

use App\Bodega;
use App\Perfil;
use App\Ruta;
use App\TipoDocumento;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getVendedor() {
        $vendedor_id = $_POST['vendedor_id'];
        if( empty($vendedor_id) ) {
            $response = array(
                'status' => false,
                'msg' => 'la id del vendedor esta vacio'
            );
            return response()->json($response);
        }
        $rutas=Ruta::where('estado','A')->where('user_id',$vendedor_id)->with('zona')->get();
        if( count($rutas) == 0 ) {
            $response = array(
                'status' => false,
                'msg' => 'El vendedor no tiene rutas asignadas'
            );
            return response()->json($response);
        }
        $response = array(
            'status' => true,
            'msg' => 'Vendedor encontrado',
            'rutas' => $rutas
        );
        return response()->json($response);
    }


    public function show( $id ) {
        $empleado = User::find( $id );
        return view( 'auth.show' )->with( compact( 'empleado' ) );
    }

    public function edit($id) {
        $bodegas = Bodega::orderBy('nombre') -> get();
        $tiposDocumento = TipoDocumento::orderBy('nombre') -> get();
        $perfiles = Perfil::orderBy('nombre')->get();
        $empleado = User::find( $id );
        return view('auth.edit')->with( compact('tiposDocumento','bodegas', 'perfiles','empleado') );
    }

    public function update( Request $request , $id ) {
//        dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        if( $request->input('tipo_documento_id') == 'I' ) {
            $request['tipo_documento_id'] = null;
        }
        if( $request->input('bodega_id') == 'I' ) {
            $request['bodega_id'] = null;
        }
        if( $request->input('perfil_id') == 'I' ) {
            $request['perfil_id'] = null;
        }
        $messages = [
            'name.required' => 'El nombre del empleado no puede ser vacio',
            'name.string' => 'El nombre solo acepta cadenas de texto',
            'name.max' => 'El nombre debe tener maximo 120 caracteres',
            'address.required' => 'La direccion no puede ser vacia',
            'address.string' => 'La direccion solo acepta cadenas de texto',
            'address.max' => 'La direccion debe tener maximo 150 caracteres',
            'tipo_documento_id.required' => 'el tipo de documento no puede ser vacio',
            'bodega_id.required' => 'La bodega no puede ser vacia',
            'perfil_id.required' => 'El perfil no puede ser vacio',
        ];
        $rules = [
            'name' => 'required|string|max:120',
            'address' => 'required|string|max:150',
            'tipo_documento_id' => 'required',
            'number_id' => 'required|',
            'bodega_id' => 'required',
            'perfil_id' => 'required',
            'phone' => '',
            'celular' => '',
            'email' => ''
        ];
        if( $request->input('phone') != "" ) {
            $rules['phone'] .= 'numeric|between:0,99999999999999999999';
        }
        if( $request->input('celular') != "" ) {
            $rules['celular'] .= 'numeric|between:0,99999999999999999999';
        }
        //consultar el cliente a editar
        $empleado = User::find( $id );
//        dd($empleado);
        if( $request->input('email') != "" && $empleado -> email != $request->input('email') ) {
            $rules['email'] .= 'string|email|max:255|unique:user,email';
        }
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,$rules,$messages);
        //luego de validar se procede a almacenar
        $empleado -> name = $request->input('name');
        $empleado -> tipo_documento_id = $request->input('tipo_documento_id');
        $empleado -> phone = $request->input('phone');
        $empleado -> celular = $request->input('celular');
        $empleado -> address = $request->input('address');
        $empleado -> email = $request->input('email');
        $empleado -> bodega_id = $request->input('bodega_id');
        $empleado -> perfil_id = $request->input('perfil_id');
        $empleado -> save(); //registrar producto
        $notification = 'Empleado Actualizado Exitosamente';
        return redirect('/empleados') -> with( compact( 'notification' ) );
    }

}
