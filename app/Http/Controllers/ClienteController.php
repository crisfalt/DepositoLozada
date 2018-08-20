<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Cliente;
use App\Bodega;
use App\Ruta;
use App\TipoDocumento;
use App\OrdenRuta;
use App\TipoNegocio;
use LynX39\LaraPdfMerger;

class ClienteController extends Controller
{

    public function index() {
//        $pdf = new LaraPdfMerger\PdfManage();
//        $pdf->addPDF(public_path().'/3.pdf', 'all');
//        $pdf->addPDF(public_path().'/3.pdf', 'all');
////        $pdf->addPDF(public_path().'/106034043.pdf', 'all');
//        $pdf->merge('download', "mergedpdf.pdf");
        $clientes = Cliente::where('estado','A')->orderBy('name') -> get();
        return view('admin.cliente.index')->with(compact('clientes')); //listado de tipos movimientos
    }

    public function show($id)
    {
        $cliente = Cliente::where( 'number_id' , $id )->first();
       
//        dd($cliente);
        return view('admin.cliente.show')->with(compact('cliente'));
    }

    //
    public function create() {
        $bodegas = Bodega::orderBy('nombre') -> get();
        $rutas = Ruta::orderBy('nombre') -> get();
        $tiposDocumento = TipoDocumento::orderBy('nombre') -> get();
        $tipoNegocio = TipoNegocio::where('estado','A')->orderBy('nombre') -> get();
        return view('admin.cliente.register')->with( compact('tiposDocumento','bodegas','rutas','tipoNegocio') );
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
        $mensajes = Cliente::$messages; //reglas a mi antojo y personalizadas
        if( $request->input('phone') != "" ) {
            $reglas['phone'] .= 'numeric|between:0,99999999999999999999';
        }
        if( $request->input('celular') != "" ) {
            $reglas['celular'] .= 'numeric|between:0,99999999999999999999';
        }
        if( $request->input('email') != "" ) {
            $reglas['email'] .= 'string|email|max:255|unique:clientes,email';
        }
//        dd( $request->input('number_id') );
        //regla de validacion para el numero de identificacion del cliente
        if( empty( $request->input('number_id') ) ) {
            $reglas['number_id'] .= 'required';
            $mensajes['number_id.required'] .= 'El Campo Numero de Identificacion es Obligatorio';
        }
        if( empty( $request->input('tipo_negocio') ) ) {
            $reglas['tipo_negocio'] .= 'required';
            $mensajes['tipo_negocio.required'] .= 'El Campo tipo de negocio es Obligatorio';
        }
        if( empty( $request->input('namenegocio') ) ) {
            $reglas['nombre_negocio'] .= 'required';
            $mensajes['nombre_negocio.required'] .= 'El Campo Nombre de Negocio es Obligatorio';
        }
        else {
            $reglas['number_id'] .= 'max:30|unique:clientes,number_id';
        }
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,$reglas,$mensajes);
        //inicio subir foto al servidor
        $file = $request->file('photo');
        if( empty( $file ) ) {
            $fileName = 'default.png';//crea una imagen asi sea igual no la sobreescribe
        }
        else {
            if (App::environment('local')) {
                $path = public_path() . '/imagenes/clientes'; //concatena public_path la ruta absoluta a public y concatena la carpeta para imagenes
            }
            else {
                $path = 'imagenes/clientes';
            }
            $fileName = uniqid() . $file->getClientOriginalName();//crea una imagen asi sea igual no la sobreescribe
            //fin subir foto al servidor
            $file->move( $path , $fileName );//dar la orden al archivo para que se guarde en la ruta indicada la sube al servidor
        }
        //crear un cliente nuevo
        $cliente = new Cliente();
        $cliente -> number_id = $request->input('number_id');
        //$product -> description = $request->input('description');
        $cliente -> name = $request->input('name');
        $cliente -> tipo_negocio_id  = $request->input('tipo_negocio');
        $cliente -> tipo_documento_id = $request->input('tipo_documento_id');
        $cliente -> phone = $request->input('phone');
        $cliente -> celular = $request->input('celular');
        $cliente -> address = $request->input('address');
        $cliente -> email = $request->input('email');
        $cliente -> bodega_id = $request->input('bodega_id');
        $cliente -> nombre_negocio = $request->input('namenegocio');
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
            $ordenRuta -> cliente_id = $request->input('number_id');
            $ordenRuta -> ruta_id = $request->input('ruta_id');
            $ordenRuta -> save();//guardamos la ordenruta
        }
        else {//no hay ningun orden se crea uno nuevo con el orden 1
            $ordenRuta = new OrdenRuta();
            $ordenRuta -> orden = 1; //agregamos un orden al que se lleva
            $ordenRuta -> cliente_id = $request->input('number_id');
            $ordenRuta -> ruta_id = $request->input('ruta_id');
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
        $tipoNegocio = TipoNegocio::where('estado','A')->orderBy('nombre') -> get();
        return view('admin.cliente.edit')->with( compact('tiposDocumento','bodegas','rutas','cliente','tipoNegocio') );
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
         if( $request->input('tipo_negocio') == 'I' ) {
            $request['tipo_negocio_id'] = null;
        }
        if( empty( $request->input('namenegocio') ) ) {
            $reglas['nombre_negocio'] .= 'required';
            $mensajes['nombre_negocio.required'] .= 'El Campo Nombre de Negocio es Obligatorio';
        }

        //consultar el cliente a editar
        $cliente = Cliente::where( 'number_id' , $id )->first();
        if( $request->input('email') != "" && $cliente -> email != $request->input('email') ) {
            $reglas['email'] .= 'string|email|max:255|unique:clientes,email';
        }
        //validar datos con reglas de laravel en documentacion hay mas
        //mensajes personalizados para cada campo
        $this->validate($request,$reglas,Cliente::$messages);
        //luego de validar se procede a almacenar
        $cliente -> name = $request->input('name');
        $cliente -> tipo_documento_id = $request->input('tipo_documento_id');
        $cliente -> tipo_negocio_id  = $request->input('tipo_negocio');
        $cliente -> phone = $request->input('phone');
        $cliente -> celular = $request->input('celular');
        $cliente -> address = $request->input('address');
        $cliente -> email = $request->input('email');
        $cliente -> bodega_id = $request->input('bodega_id');
        $cliente -> nombre_negocio = $request->input('namenegocio');
        $cliente -> ruta_id = $request->input('ruta_id');
        $cliente -> valor_credito = $request->input('valor_credito');
        //inicio subir foto al servidor
        $file = $request->file('photo');
        $fileName = $cliente->url_foto; //obtengo la foto actual del cliente
        if( !empty( $file ) ) {
            if (App::environment('local')) {
                $path = public_path() . '/imagenes/clientes'; //concatena public_path la ruta absoluta a public y concatena la carpeta para imagenes
            }
            else {
                $path = 'imagenes/clientes';
            }
            $fileName = uniqid() . $file->getClientOriginalName();//crea una imagen asi sea igual no la sobreescribe
            //fin subir foto al servidor
            $file->move( $path , $fileName );//dar la orden al archivo para que se guarde en la ruta indicada la sube al servidor
        }
        $cliente -> url_foto = $fileName;
        $cliente -> save(); //registrar producto
        //actualizar el cliente en el orden de la ruta
        $ordenRuta = OrdenRuta::where('cliente_id',$id)->first();
        $ordenRuta->ruta_id = $request->input('ruta_id');
        $ordenRuta->save();
        $notification = 'Cliente Actualizado Exitosamente';
        return redirect('/cliente') -> with( compact( 'notification' ) );
    }

    public function destroy( $id ) {
        $cliente = Cliente::find($id);
        $cliente->estado = 'I';
        $cliente->save();
        $notification = 'Cliente '.$cliente->name.' eliminado correctamente';
        return back() -> with( compact( 'notification' ) ); //nos devuelve a la pagina anterior
    }


}
