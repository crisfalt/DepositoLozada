<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Bodega;
use App\Ruta;
use App\TipoDocumento;
use App\OrdenRuta;

class ClienteController extends Controller
{

    public function index() {
        $clientes = Cliente::orderBy('name') -> get();
        return view('admin.cliente.index')->with(compact('clientes')); //listado de tipos movimientos
    }

    public function show($id)
    {
        $cliente = Cliente::where( 'number_id' , $id )->first();
        return view('admin.cliente.show')->with(compact('cliente'));
    }

    //
    public function create() {
        $bodegas = Bodega::orderBy('nombre') -> get();
        $rutas = Ruta::orderBy('nombre') -> get();
        $tiposDocumento = TipoDocumento::orderBy('nombre') -> get();
        return view('admin.cliente.register')->with( compact('tiposDocumento','bodegas','rutas') );
    }

    public function store( Request $request ) {
        //dd($request->all());//el metodo permite imprimir todos los datos del request
        // return view(); //almacenar el registro de un producto
        if( $request->input('tipo_documento_id') == 'I' ) {
            $request['tipo_documento_id'] = null;
        }
        if( $request->input('bodega_id') == 'I' ) {
            $request['bodega_id'] = null;
        }
        if( $request->input('ruta_id') == 'I' ) {
            $request['ruta_id'] = null;
        }
        $reglas = Cliente::$rules; //reglas a mi antojo y personalizadas
        if( $request->input('phone') != "" ) {
            $reglas['phone'] .= 'numeric|between:0,99999999999999999999';
        }
        if( $request->input('celular') != "" ) {
            $reglas['celular'] .= 'numeric|between:0,99999999999999999999';
        }
        if( $request->input('email') != "" ) {
            $reglas['email'] .= 'string|email|max:255|unique:clientes,email';
        }
        if( empty( $request->file('photo') ) ) {
            $reglas['photo'] .= 'required';
        }
        //regla de validacion para el numero de identificacion del cliente
        if( empty( $request->input('number_id') ) ) {
            $reglas['number_id'] .= 'required';
        }
        else {
            $reglas['number_id'] .= 'max:30|unique:clientes,number_id';
        }
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,$reglas,Cliente::$messages);
        //inicio subir foto al servidor
        $file = $request->file('photo');
        $path = public_path() . '/imagenes/clientes'; //concatena public_path la ruta absoluta a public y concatena la carpeta para imagenes
        $fileName = uniqid() . $file->getClientOriginalName();//crea una imagen asi sea igual no la sobreescribe
        //fin subir foto al servidor
        $file->move( $path , $fileName );//dar la orden al archivo para que se guarde en la ruta indicada la sube al servidor
        //crear un cliente nuevo
        $cliente = new Cliente();
        $cliente -> number_id = $request->input('number_id');
        //$product -> description = $request->input('description');
        $cliente -> name = $request->input('name');
        $cliente -> tipo_documento_id = $request->input('tipo_documento_id');
        $cliente -> phone = $request->input('phone');
        $cliente -> celular = $request->input('celular');
        $cliente -> address = $request->input('address');
        $cliente -> email = $request->input('email');
        $cliente -> bodega_id = $request->input('bodega_id');
        $cliente -> ruta_id = $request->input('ruta_id');
        $cliente -> valor_credito = $request->input('valor_credito');
        $cliente -> url_foto = $fileName;
        $cliente -> estado = "A";
        $cliente -> save(); //registrar producto
        //luego de creado el cliente se agrega al orden_rutas en la ultima ruta
        $ultimoOrdenRuta = OrdenRuta::where('ruta_id',$cliente->ruta_id)->orderBy('orden','ASC')->get()->last();//obtenemos el ultimo numero de una ruta
        if( !empty( $ultimoOrdenRuta ) ) { //si existe ya un orden 
            $ordenRuta = new OrdenRuta();
            $ordenRuta -> orden = $ultimoOrdenRuta -> orden + 1; //agregamos un orden al que se lleva
            $ordenRuta -> cliente_id = $cliente -> number_id;
            $ordenRuta -> ruta_id = $cliente -> ruta_id;
            $ordenRuta -> save();//guardamos la ordenruta
        }
        else {//no hay ningun orden se crea uno nuevo con el orden 1
            $ordenRuta = new OrdenRuta();
            $ordenRuta -> orden = 1; //agregamos un orden al que se lleva
            $ordenRuta -> cliente_id = $cliente -> number_id;
            $ordenRuta -> ruta_id = $cliente -> ruta_id;
            $ordenRuta -> save();//guardamos la ordenruta
        }
        $notification = 'Cliente Registrado Exitosamente';
        return redirect('/cliente') -> with( compact( 'notification' ) );
    }

    public function edit($id) {
        $bodegas = Bodega::orderBy('nombre') -> get();
        $rutas = Ruta::orderBy('nombre') -> get();
        $tiposDocumento = TipoDocumento::orderBy('nombre') -> get();
        $cliente = Cliente::where('number_id',$id)->first();
        return view('admin.cliente.edit')->with( compact('tiposDocumento','bodegas','rutas','cliente') );
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
        if( $request->input('ruta_id') == 'I' ) {
            $request['ruta_id'] = null;
        }
        $reglas = Cliente::$rules; //reglas a mi antojo y personalizadas
        if( $request->input('phone') != "" ) {
            $reglas['phone'] .= 'numeric|between:0,99999999999999999999';
        }
        if( $request->input('celular') != "" ) {
            $reglas['celular'] .= 'numeric|between:0,99999999999999999999';
        }
        if( $request->input('email') != "" ) {
            $reglas['email'] .= 'string|email|max:255|unique:clientes,email';
        }
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,$reglas,Cliente::$messages);
        //consultar el cliente a editar
        $cliente = Cliente::where( 'number_id' , $id )->first();
        $cliente -> name = $request->input('name');
        $cliente -> tipo_documento_id = $request->input('tipo_documento_id');
        $cliente -> phone = $request->input('phone');
        $cliente -> celular = $request->input('celular');
        $cliente -> address = $request->input('address');
        $cliente -> email = $request->input('email');
        $cliente -> bodega_id = $request->input('bodega_id');
        $cliente -> ruta_id = $request->input('ruta_id');
        $cliente -> valor_credito = $request->input('valor_credito');
        //inicio subir foto al servidor
        $file = $request->file('photo');
        $fileName = $cliente->url_foto; //obtengo la foto actual del cliente
        if( !empty( $file ) ) {
            $path = public_path() . '/imagenes/clientes'; //concatena public_path la ruta absoluta a public y concatena la carpeta para imagenes
            $fileName = uniqid() . $file->getClientOriginalName();//crea una imagen asi sea igual no la sobreescribe
            //fin subir foto al servidor
            $file->move( $path , $fileName );//dar la orden al archivo para que se guarde en la ruta indicada la sube al servidor
        }
        $cliente -> url_foto = $fileName;
        $cliente -> save(); //registrar producto
        $notification = 'Cliente Actualizado Exitosamente';
        return redirect('/cliente') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        
        $notification = 'El Cliente aun no se elimina por cupla de kevin';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }


}
