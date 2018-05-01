<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/caja/cajas' , 'CajaController@getCajas'); //todas las cajas disponibles
Route::post('/caja/asignar/{caja}/{valor}' , 'CajaController@asignarCaja'); //asignar caja a la session actual

Route::middleware(['auth', 'admin'])->group(function () {
    //CRUD Clientes
    Route::get('/cliente' , 'ClienteController@index')->name('cliente');
    Route::get('/cliente/create' , 'ClienteController@create');
    Route::post('/cliente' , 'ClienteController@store');
    Route::delete('/cliente/{id}','ClienteController@destroy'); //vista para eliminar
    Route::get('/cliente/{id}','ClienteController@show'); //mostrar el tipo de movimiento
    Route::get('/cliente/{id}/edit' , 'ClienteController@edit');
    Route::post('/cliente/{id}/edit' , 'ClienteController@update');

    //CRUD Proveedores
    Route::get('/proveedor' , 'ProveedorController@index')->name('proveedor');
    Route::get('/proveedor/create' , 'ProveedorController@create');
    Route::post('/proveedor' , 'ProveedorController@store');
    Route::delete('/proveedor/{id}','ProveedorController@destroy'); //vista para eliminar
    Route::get('/proveedor/{id}','ProveedorController@show'); //mostrar el tipo de movimiento
    Route::get('/proveedor/{id}/edit' , 'ProveedorController@edit');
    Route::post('/proveedor/{id}/edit' , 'ProveedorController@update');

    //CRUD cajas
    Route::get('/caja' , 'CajaController@index')->name('caja');
    Route::get('/caja/create' , 'CajaController@create');
    Route::post('/caja' , 'CajaController@store');
    Route::delete('/caja/{id}','CajaController@destroy'); //vista para eliminar
    Route::get('/caja/{id}','CajaController@show'); //mostrar el tipo de movimiento
    Route::get('/caja/{id}/edit' , 'CajaController@edit');
    Route::post('/caja/{id}/edit' , 'CajaController@update');

    //CRUD perfiles
    Route::get('/perfil' , 'PerfilController@index')->name('perfil');
    Route::get('/perfil/create' , 'PerfilController@create');
    Route::post('/perfil' , 'PerfilController@store');
    Route::delete('/perfil/{id}','PerfilController@destroy'); //vista para eliminar
    Route::get('/perfil/{id}','PerfilController@show'); //mostrar el tipo de movimiento
    Route::get('/perfil/{id}/edit' , 'PerfilController@edit');
    Route::post('/perfil/{id}/edit' , 'PerfilController@update');

    //CRUD Zonas
    Route::get('/zona' , 'ZonaController@index')->name('zona');
    Route::get('/zona/create' , 'ZonaController@create');
    Route::post('/zona' , 'ZonaController@store');
    Route::delete('/zona/{id}','ZonaController@destroy'); //vista para eliminar
    Route::get('/zona/{id}','ZonaController@show'); //mostrar el tipo de movimiento
    Route::get('/zona/{id}/edit' , 'ZonaController@edit');
    Route::post('/zona/{id}/edit' , 'ZonaController@update');

    //CRUD Rutas de las zonas
    Route::get('/zona/{id}/rutas' , 'RutaController@index');
    Route::get('/ruta/{id}/create' , 'RutaController@create');
    Route::post('/ruta' , 'RutaController@store');
    Route::delete('/ruta/{id}','RutaController@destroy'); //vista para eliminar
    Route::get('/ruta/{id}','RutaController@show'); //mostrar el tipo de movimiento
    Route::get('/ruta/{id}/edit' , 'RutaController@edit');
    Route::post('/ruta/{id}/edit' , 'RutaController@update');

    //CRUD TIPOS DE MOVIMIENTOS
    Route::get('/tipomovimiento' , 'TipoMovimientoController@index')->name('tipomovimiento');
    Route::get('/tipomovimiento/create' , 'TipoMovimientoController@create');
    Route::post('/tipomovimiento' , 'TipoMovimientoController@store');
    Route::delete('/tipomovimiento/{id}','TipoMovimientoController@destroy'); //vista para eliminar
    Route::get('/tipomovimiento/{id}','TipoMovimientoController@show'); //mostrar el tipo de movimiento
    Route::get('/tipomovimiento/{id}/edit' , 'TipoMovimientoController@edit');
    Route::post('/tipomovimiento/{id}/edit' , 'TipoMovimientoController@update');

    //CRUD MARCAS
    Route::get('/marca' , 'MarcaController@index')->name('marca');
    Route::get('/marca/create' , 'MarcaController@create');
    Route::post('/marca' , 'MarcaController@store');
    Route::delete('/marca/{id}','MarcaController@destroy'); //vista para eliminar
    Route::get('/marca/{id}','MarcaController@show'); //mostrar el tipo de movimiento
    Route::get('/marca/{id}/edit' , 'MarcaController@edit');
    Route::post('/marca/{id}/edit' , 'MarcaController@update');

    //CRUD TAMAÑO ENVASES
    Route::get('/sizebotella' , 'SizeBotellaController@index')->name('sizebotella');
    Route::get('/sizebotella/create' , 'SizeBotellaController@create');
    Route::post('/sizebotella' , 'SizeBotellaController@store');
    Route::delete('/sizebotella/{id}','SizeBotellaController@destroy'); //vista para eliminar
    Route::get('/sizebotella/{id}','SizeBotellaController@show'); //mostrar el tipo de movimiento
    Route::get('/sizebotella/{id}/edit' , 'SizeBotellaController@edit');
    Route::post('/sizebotella/{id}/edit' , 'SizeBotellaController@update');

    //CRUD TIPOS ENVASES
    Route::get('/tipoenvase' , 'TipoEnvaseController@index')->name('tipoenvase');
    Route::get('/tipoenvase/create' , 'TipoEnvaseController@create');
    Route::post('/tipoenvase' , 'TipoEnvaseController@store');
    Route::delete('/tipoenvase/{id}','TipoEnvaseController@destroy'); //vista para eliminar
    Route::get('/tipoenvase/{id}','TipoEnvaseController@show'); //mostrar el tipo de movimiento
    Route::get('/tipoenvase/{id}/edit' , 'TipoEnvaseController@edit');
    Route::post('/tipoenvase/{id}/edit' , 'TipoEnvaseController@update');

    //CRUD TIPOS CONTENIDO
    Route::get('/tipocontenido' , 'TipoContenidoController@index')->name('tipocontenido');
    Route::get('/tipocontenido/create' , 'TipoContenidoController@create');
    Route::post('/tipocontenido' , 'TipoContenidoController@store');
    Route::delete('/tipocontenido/{id}','TipoContenidoController@destroy'); //vista para eliminar
    Route::get('/tipocontenido/{id}','TipoContenidoController@show'); //mostrar el tipo de movimiento
    Route::get('/tipocontenido/{id}/edit' , 'TipoContenidoController@edit');
    Route::post('/tipocontenido/{id}/edit' , 'TipoContenidoController@update');

    //CRUD TIPOS PACAS
    Route::get('/tipopaca' , 'TipoPacaController@index')->name('tipopaca');
    Route::get('/tipopaca/create' , 'TipoPacaController@create');
    Route::post('/tipopaca' , 'TipoPacaController@store');
    Route::delete('/tipopaca/{id}','TipoPacaController@destroy'); //vista para eliminar
    Route::get('/tipopaca/{id}','TipoPacaController@show'); //mostrar el tipo de movimiento
    Route::get('/tipopaca/{id}/edit' , 'TipoPacaController@edit');
    Route::post('/tipopaca/{id}/edit' , 'TipoPacaController@update');

    //CRUD BODEGAS
    Route::get('/bodega' , 'BodegaController@index')->name('bodega');
    Route::get('/bodega/create' , 'BodegaController@create');
    Route::post('/bodega' , 'BodegaController@store');
    Route::delete('/bodega/{id}','BodegaController@destroy'); //vista para eliminar
    Route::get('/bodega/{id}','BodegaController@show'); //mostrar el tipo de movimiento
    Route::get('/bodega/{id}/edit' , 'BodegaController@edit');
    Route::post('/bodega/{id}/edit' , 'BodegaController@update');

    //CRUD PRoductos
    Route::get('/producto' , 'ProductoController@index')->name('producto');
    Route::get('/producto/create' , 'ProductoController@create');
    Route::post('/producto' , 'ProductoController@store');
    Route::delete('/producto/{id}','ProductoController@destroy'); //vista para eliminar
    Route::get('/producto/{id}','ProductoController@show'); //mostrar el tipo de movimiento
    Route::get('/producto/{id}/edit' , 'ProductoController@edit');
    Route::post('/producto/{id}/edit' , 'ProductoController@update');

    //CRUD Descripcion de Precio
    Route::get('/descripcionprecio' , 'DescripcionPrecioController@index')->name('descripcionprecio');
    Route::get('/descripcionprecio/create' , 'DescripcionPrecioController@create');
    Route::post('/descripcionprecio' , 'DescripcionPrecioController@store');
    Route::delete('/descripcionprecio/{id}','DescripcionPrecioController@destroy'); //vista para eliminar
    Route::get('/descripcionprecio/{id}','DescripcionPrecioController@show'); //mostrar el tipo de movimiento
    Route::get('/descripcionprecio/{id}/edit' , 'DescripcionPrecioController@edit');
    Route::post('/descripcionprecio/{id}/edit' , 'DescripcionPrecioController@update');

    //CRUD Descripcion de Precio
    Route::get('/descripcioniva' , 'DescripcionIvaController@index')->name('descripcioniva');
    Route::get('/descripcioniva/create' , 'DescripcionIvaController@create');
    Route::post('/descripcioniva' , 'DescripcionIvaController@store');
    Route::delete('/descripcioniva/{id}','DescripcionIvaController@destroy'); //vista para eliminar
    Route::get('/descripcioniva/{id}','DescripcionIvaController@show'); //mostrar el tipo de movimiento
    Route::get('/descripcioniva/{id}/edit' , 'DescripcionIvaController@edit');
    Route::post('/descripcioniva/{id}/edit' , 'DescripcionIvaController@update');

    //CRUD IMAGENES DE UN PRODUCTO
    Route::get('/producto/{codigo}/imagenes', 'ImagenesProductoController@index'); // listado
    Route::post('/producto/{codigo}/imagenes', 'ImagenesProductoController@store'); // registrar
    Route::delete('/producto/{codigo}/imagenes', 'ImagenesProductoController@destroy'); // form eliminar
    Route::get('/producto/{codigo}/imagenes/select/{image}', 'ImagenesProductoController@select'); // destacar
});

Route::middleware(['auth', 'vendedor'])->prefix('vendedor')->namespace('Vendedor')->group(function () {
    //CRUD PRoductos
    Route::get('/producto' , 'ProductoController@index'); //listar productos
    Route::get('/producto/{id}','ProductoController@show'); //mostrar el producto seleccionado
});
