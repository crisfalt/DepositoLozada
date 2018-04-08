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

Route::get('/welcome', function () {
    return view('welcome');
});

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

//CRUD IMAGENES DE UN PRODUCTO
Route::get('/producto/{codigo}/imagenes', 'ImagenesProductoController@index'); // listado
Route::post('/producto/{codigo}/imagenes', 'ImagenesProductoController@store'); // registrar
Route::delete('/producto/{codigo}/imagenes', 'ImagenesProductoController@destroy'); // form eliminar
Route::get('/producto/{codigo}/imagenes/select/{image}', 'ImagenesProductoController@select'); // destacar

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
