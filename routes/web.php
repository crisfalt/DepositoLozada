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


     //Cartera
     Route::get('/cartera' , 'CarteraController@index')->name('cartera');
     Route::get('/cartera/searchVenta/{idDepa}','CarteraController@searchVentas');
    

    //CRUD Empleados
    Route::get('empleados' , 'Auth\RegisterController@index')->name('empleados');
    Route::delete('/empleados/{id}','Auth\RegisterController@destroy'); //vista para eliminar
    //CRUD abonosventa
    Route::get('/abono/searchTotal/{saldoventa}','AbonoController@searchTotal');
    Route::get('abono' , 'AbonoController@index')->name('abono');
    Route::get('/abono/create' , 'AbonoController@create');
    Route::post('/abono' , 'AbonoController@store');
    Route::delete('/abono/{id}','AbonoController@destroy'); //vista para eliminar
    //CRUD abonocompra
    Route::get('/abonocompra/searchTotal/{saldoventa}','AbonoCompraController@searchTotal');
    Route::get('abonocompra' , 'AbonoCompraController@index')->name('abonocompra');
    Route::get('/abonocompra/create' , 'AbonoCompraController@create');
    Route::post('/abonocompra' , 'AbonoCompraController@store');
    Route::delete('/abonocompra/{id}','AbonoCompraController@destroy'); //vista para eliminar

    //Rutas Cargue
    Route::get('/cargue' , 'CargueController@index')->name('cargue');
    Route::get('/cargue/create' , 'CargueController@create');
    Route::get('/cargue/deldia' , 'CargueController@deldia');//obtener el cargue guardado del dia de hoy
    Route::get('/cargue/filtrar/' , 'CargueController@filtrar');//filtrar por ajax las fechas
    Route::post('/cargue/create' , 'CargueController@store');//guardar el cargue

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
    Route::get('/caja/closed' , 'CajaController@closed');
    Route::get('/caja/entrada' , 'CajaController@entrada');//ruta para las entradas de la caja
    Route::get('/caja/salida' , 'CajaController@salida');//ruta para las entradas de la caja
    Route::post('/caja' , 'CajaController@store');
    ///////el recibo///////////////////
    Route::get('/caja/imprimir/{id}' , 'MovimientoCajaController@imprimir'); //imprimir recibo de salida de caja 
    ////////////
    Route::delete('/caja/{id}','CajaController@destroy'); //vista para eliminar
    Route::get('/caja/{id}','CajaController@show'); //mostrar el tipo de movimiento
    Route::get('/caja/{id}/edit' , 'CajaController@edit');
    Route::post('/caja/{id}/edit' , 'CajaController@update');
    Route::post('/caja/entrada' , 'CajaController@storeMovimiento');
    Route::post('/caja/salida' , 'CajaController@storeMovimiento');

    //CRUD Movimiento Cajas
    Route::get('/movimientocaja' , 'MovimientoCajaController@index')->name('movimientocaja');

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
    Route::get('/zona/search/rutas/json',array('as'=>'zona.search.rutas.json','uses'=>'ZonaController@getRutas'));
    Route::get('/zona/vendedor/asignar_ruta',array('as'=>'zona.vendedor.asignar_ruta','uses'=>'ZonaController@asignarZona'));
    Route::post('/zona/vendedor/actualizar_asignacion',array('as'=>'zona.vendedor.actualizar_asignacion','uses'=>'ZonaController@actualizarAsginacion'));
    Route::get('searchajax',array('as'=>'searchajax','uses'=>'ZonaController@autoComplete'));

    //CRUD Rutas de las zonas
    Route::get('/zona/{id}/rutas' , 'RutaController@index');
    Route::get('/ruta/{id}/create' , 'RutaController@create');
    Route::get('/ruta/alls' , 'RutaController@allRutas');//traer todas las rutas
    Route::get('/ruta/{id}/map' , 'RutaController@loadMap');//cargar mapa de la ruta seleccionada
    Route::get('/ruta/{id}/details' , 'RutaController@details');//muestra los clientes en una ruta
    Route::post('/ruta/reordenar' , 'RutaController@reordenar');//metodo que almacena elnuevo orden
    Route::post('/ruta' , 'RutaController@store');
    Route::delete('/ruta/{id}','RutaController@destroy'); //vista para eliminar
    Route::get('/ruta/{id}','RutaController@show'); //mostrar el tipo de movimiento
    Route::get('/ruta/{id}/edit' , 'RutaController@edit');
    Route::post('/ruta/{id}/edit' , 'RutaController@update');
    Route::post('/ruta/dia/eliminar' , 'RutaController@deleteDay'); //eliminar un dia de la lista de ruta

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
    Route::post('/producto/precio_o_iva/eliminar' , 'ProductoController@deletePrecioOIva');
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

    //CRUD estado compra
    Route::get('estadocompra' , 'EstadoCompraController@index')->name('estadocompra');
    Route::get('/estadocompra/create' , 'EstadoCompraController@create');
    Route::post('/estadocompra' , 'EstadoCompraController@store');
    Route::delete('/estadocompra/{id}','EstadoCompraController@destroy'); //vista para eliminar
    Route::get('/estadocompra/{id}','EstadoCompraController@show'); //mostrar el tipo de 
    Route::get('/estadocompra/{id}/edit' , 'EstadoCompraController@edit');
    Route::post('/estadocompra/{id}/edit' , 'EstadoCompraController@update');

    //CRUD estado venta
    Route::get('estadoventa' , 'EstadoVentaController@index')->name('estadoventa');
    Route::get('/estadoventa/create' , 'EstadoVentaController@create');
    Route::post('/estadoventa' , 'EstadoVentaController@store');
    Route::delete('/estadoventa/{id}','EstadoVentaController@destroy'); //vista para eliminar
    Route::get('/estadoventa/{id}','EstadoVentaController@show'); //mostrar el tipo de 
    Route::get('/estadoventa/{id}/edit' , 'EstadoVentaController@edit');
    Route::post('/estadoventa/{id}/edit' , 'EstadoVentaController@update');
    //CRUD forma pago
    Route::get('/formapago' , 'FormaPagoController@index')->name('formapago');
    Route::get('/formapago/create' , 'FormaPagoController@create');
    Route::post('/formapago' , 'FormaPagoController@store');
    Route::delete('/formapago/{id}','FormaPagoController@destroy'); //vista para eliminar
    Route::get('/formapago/{id}','FormaPagoController@show'); //mostrar el tipo de 
    Route::get('/formapago/{id}/edit' , 'FormaPagoController@edit');
    Route::post('/formapago/{id}/edit' , 'FormaPagoController@update');
    //CRUD ecompra
    Route::get('compra' , 'compraController@index')->name('compra');
    Route::get('/compra/create' , 'compraController@create');
    Route::post('/compra' , 'compraController@store');
    Route::delete('/compra/{id}','compraController@destroy'); //vista para eliminar
    Route::get('/compra/{id}','compraController@show'); //mostrar el tipo de 
    Route::get('/compra/{id}/edit' , 'compraController@edit');
    Route::get('/compra/edit/{id}/{estado}' , 'compraController@update');	
    Route::post('/compra/agregarCantidad/{cantidad}/{id}' , 'compraController@agregrarCantidad');
    Route::post('/compra/agregrarCantidadEditar/{cantidad}/{id}' , 'compraController@agregrarCantidadEditar');
    Route::post('/compra/MostrarCanastaIndividual/{id}' , 'compraController@MostrarCanastaIndividual',function($id)
    {
        $PrecioProducto_id = $id;

        $precio =  PreciosProducto:: find ($PrecioProducto_id ) -> fk_producto;

        return Response::json( $precio);
    });

    
    Route::get('/compra/ConsultarCanasta/{tipopaca}' , 'compraController@ConsultarCanasta');
    Route::post('/compra/AgregarCanasta' , 'compraController@AgregarCanasta');
    //////consultar y agregar edit
    Route::get('/compra/ConsultarCanastaEditar/{tipopaca}' , 'compraController@ConsultarCanastaEditar');
    Route::post('/compra/AgregarCanastaEditar' , 'compraController@AgregarCanastaEditar');

    
    Route::get('/compracabeza/{id}/edit' , 'compraController@editcabeza');
    Route::post	('/compracabeza/edit/{id}' , 'compraController@updatecabeza');

    //cabezaeditarcrear
    Route::get('/compracabezacrear/{id}/edit' , 'compraController@editcabezacrear');
    Route::post	('/compracabezacrear/edit/{id}' , 'compraController@updatecabezacrear');
    Route::get('/compra/recibo/{id}/{estado}/{abono}' , 'compraController@recibo');
    Route::get('/compra/imprimir/{id}/{estado}' , 'compraController@imprimir');
    Route::get('/compra/cerrarSesion/{idSesion}','CompraController@cerrarSesion');
    Route::get('/compra/cerrarSesion/{idSesion}','compraController@cerrarSesion');
    ///filtros de compras create
    Route::post('/compra/MostrarMarca/{id}','compraController@marca');
    Route::get('/compra/MostrarTipoContenido/{id}','compraController@tipoContenido');
    Route::get('/compra/MostrarTipoPaca/{id}','compraController@tipoPaca');
    Route::get('/compra/MostrarProducto/{id}','compraController@Producto');
    ///filtros de compras editar
    Route::post('/compra/MostrarMarcaEditar/{id}','compraController@marcaEditar');
    Route::get('/compra/MostrarTipoContenidoEditar/{id}','compraController@tipoContenidoEditar');
    Route::get('/compra/MostrarTipoPacaEditar/{id}','compraController@tipoPacaEditar');
    Route::get('/compra/MostrarProductoEditar/{id}','compraController@ProductoEditar');

    //CRUD venta
    ///para hacer en venta abono create y agregar  la cantidad de producto en detalles de venta
    Route::post('venta/BuscarCliente/' , 'VentaController@BuscarCliente');
    Route::post('/venta/abonar' , 'VentaController@abonar');
    Route::get('venta' , 'VentaController@index')->name('venta');
    Route::get('/venta/{id_cliente}/create' , 'VentaController@create');
    Route::post('/venta' , 'VentaController@store');
    Route::delete('/venta/{id}','VentaController@destroy'); //vista para eliminar
    Route::get('/venta/{id}','VentaController@show'); //mostrar el tipo de 
    Route::get('/venta/{id}/edit' , 'VentaController@edit');
    Route::get('/venta/edit/{id}/{estado}' , 'VentaController@update');	
    Route::post('/venta/agregarCantidad/{cantidad}/{id}' , 'VentaController@agregrarCantidad');
    Route::post('/venta/agregarCantidadEditar/{cantidad}/{id}' , 'VentaController@agregrarCantidadEditar');
    //////consultar y agregar canasta create y edit controlador venta
    Route::post('/venta/MostrarCanastaIndividual/{id}' , 'VentaController@MostrarCanastaIndividual',function($id)
    {
        $PrecioProducto_id = $id;

        $precio =  PreciosProducto:: find ($PrecioProducto_id ) -> fk_producto;

        return Response::json( $precio);
    });
    
    Route::post('/venta/MostrarCanastaIndividualEditar/{id}' , 'VentaController@MostrarCanastaIndividualEditar',function($id)
    {
        $PrecioProducto_id = $id;
        $precio =  PreciosProducto:: find ($PrecioProducto_id ) -> fk_producto;
        return Response::json( $precio);
    });
    Route::get('/venta/ConsultarCanasta/{tipopaca}' , 'VentaController@ConsultarCanasta');
    Route::post('/venta/AgregarCanasta' , 'VentaController@AgregarCanasta');
    //////consultar y agregar edit controlador venta
    Route::get('/venta/ConsultarCanastaEditar/{tipopaca}' , 'VentaController@ConsultarCanastaEditar');
    Route::post('/venta/AgregarCanastaEditar' , 'VentaController@AgregarCanastaEditar');
    Route::post('/venta/ActualizarFechaEntrega' , 'VentaController@ActualizarFechaEntrega');
    Route::post('/venta/ActualizarFechaHora' , 'VentaController@ActualizarHoraEntrega');
    Route::get('/ventacabeza/{id}/edit' , 'VentaController@editcabeza');
    Route::post	('/ventacabeza/edit/{id}' , 'VentaController@updatecabeza');
    //cabezaeditarcrear en el controlador de venta
    Route::get('/ventacabezacrear/{id}/edit' , 'VentaController@editcabezacrear');
    Route::post	('/ventacabezacrear/edit/{id}' , 'VentaController@updatecabezacrear');
    ////rutas para generar  recibos y cerrar sesion 
    Route::get('/venta/recibo/{id}/{estado}/{abono}' , 'VentaController@recibo');
    Route::get('/venta/imprimir/{id}/{estado}' , 'VentaController@imprimir');
    Route::get('/venta/cerrarSesion/{idSesion}','CompraController@cerrarSesion');
    Route::get('/venta/cerrarSesion/{idSesion}','VentaController@cerrarSesion');
    ///filtros de ventas create
    Route::post('/venta/MostrarMarca/{id}','VentaController@marca');
    Route::get('/venta/MostrarTipoContenido/{id}','VentaController@tipoContenido');
    Route::get('/venta/MostrarTipoPaca/{id}','VentaController@tipoPaca');
    Route::get('/venta/MostrarProducto/{id}','VentaController@Producto');
    ///filtros de ventas editar
    Route::post('/venta/MostrarMarcaEditar/{id}','VentaController@marcaEditar');
    Route::get('/venta/MostrarTipoContenidoEditar/{id}','VentaController@tipoContenidoEditar');
    Route::get('/venta/MostrarTipoPacaEditar/{id}','VentaController@tipoPacaEditar');
    Route::get('/venta/MostrarProductoEditar/{id}','VentaController@ProductoEditar');

    //cambia estado de la venta a entregado
    Route::post('/venta/cambiaEstado/','VentaController@cambiaEstado');

    //devolucion
    Route::post('/venta/agregarCantidadDevolucion' , 'VentaController@agregrarCantidadDevolucion');
    Route::post('/compra/agregarCantidadDevolucion' , 'compraController@agregrarCantidadDevolucion');

    //CRUD detalle venta
    Route::get('detalleventa' , 'DetalleVentaController@index')->name('DetalleVenta');
    Route::get('/detalleventa/create' , 'DetalleVentaController@create');
    Route::post('/detalleventa' , 'DetalleVentaController@store');
    Route::post('/detalleventa/{id}/{numero_canasta}','DetalleVentaController@destroy'); //vista para eliminar
    Route::post('/detalleventaEdit/{id}/{numero_canasta}','DetalleVentaController@destroyEdit');
    Route::get('/detalleventa/{id}','DetalleVentaController@show'); //mostrar el tipo de 
    Route::get('/detalleventa/{id}/edit' , 'DetalleVentaController@edit');
    Route::post('/detalleventa/{id}/edit' , 'DetalleVentaController@update');




    //CRUD detalle compra
    Route::get('detallecompra' , 'DetallecompraController@index')->name('Detallecompra');
    Route::get('/detallecompra/create' , 'DetallecompraController@create');
    Route::post('/detallecompra' , 'DetallecompraController@store');
    Route::post('/detallecompra/{id}/{numero_canasta}','DetallecompraController@destroy'); //vista para eliminar
    Route::post('/detallecompraEdit/{id}/{numero_canasta}','DetallecompraController@destroyEdit'); 
    Route::get('/detallecompra/{id}','DetallecompraController@show'); //mostrar el tipo de 
    Route::get('/detallecompra/{id}/edit' , 'DetallecompraController@edit');
    Route::post('/detallecompra/{id}/edit' , 'DetallecompraController@update');


    //ruta buscador
    Route::get('/search','SearchController@show');
    Route::post('/AgregarCompra', 'CompraController@AgregarCompra');
    Route::post('/AgregarCompraEditar', 'CompraController@AgregarCompraEditar');
    Route::post('/AgregarVenta', 'VentaController@AgregarVenta');
    Route::post('/AgregarVentaEditar', 'VentaController@AgregarVentaEditar');


    //buscador
    Route::get('/proveedors/json','SearchController@data');
    Route::get('/productos/json','SearchController@data2');
    Route::get('/precio/{id}/json','SearchController@precio');

});

Route::middleware(['auth', 'vendedor'])->prefix('vendedor')->namespace('Vendedor')->group(function () {
    //CRUD PRoductos
    Route::get('/producto' , 'ProductoController@index'); //listar productos
    Route::get('/producto/{id}','ProductoController@show'); //mostrar el producto seleccionado
});
