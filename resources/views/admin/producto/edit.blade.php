@extends('layouts.app')

@section('title','Editar Producto')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('titulo-contenido','Editar Producto')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
        <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Actualizar Producto {{ $producto -> nombre }}  <i class="fa fa-sync fa-spin fa-2x"></i> </h5>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar los errores capturados por validate -->
                        @if ($errors->any())
                        <div class="alert alert-warning">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form method="post" action="{{ url('/producto/'.$producto->codigo.'/edit') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12 pr-1">
                                    <div class="form-group">
                                        <label>Codigo</label>
                                        <input type="text" class="form-control" name="codigo" value="{{ old('codigo',$producto->codigo) }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pr-1">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" class="form-control" name="nombre" value="{{ old('nombre',$producto->nombre) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pr-1">
                                    <div class="form-group">
                                        <label>Descripcion</label>
                                        <textarea class="form-control" placeholder="Descripción" rows="5" name="descripcion">{{ old('descripcion',$producto->descripcion) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pr-1">
                                    <div class="form-group">
                                        <label>Cantidad</label>
                                        <input type="number" class="form-control" name="cantidad" value="{{ old('cantidad',$producto->cantidad) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pr-1">
                                    <div class="form-group">
                                        <label>Cantidad De Reserva</label>
                                        <input type="number" class="form-control" name="cantidad_reserva" value="{{ old('cantidad_reserva',$producto->cantidad_reserva) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pr-1">
                                    <div class="form-group">
                                        <label>Precio de Compra</label>
                                        <input type="number" class="form-control" id="precio_compra" name="precio_compra" step="0.0001" onkeypress="return solo_enteros_o_decimales(event)" value="{{ old('precio_compra', $producto->precio_compra) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Marcas</label>
                                        <select class="form-control" name="fk_marca">
                                                <option class="form-control" value="I">Seleccione</option>
                                                @foreach ( $marcas as $marca )
                                                    <option class="form-control" value="{{ $marca->id }}" @if( $marca -> id == old( 'fk_marca',$producto->fk_marca) )  selected @endif>{{ $marca->nombre }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tamaño del Producto</label>
                                        <select class="form-control" name="fk_size">
                                                <option class="form-control" value="I">Seleccione</option>
                                                @foreach ( $sizes as $size )
                                                    <option class="form-control" value="{{ $size->id }}" @if( $size -> id == old( 'fk_size',$producto->fk_size ) )  selected @endif>{{ $size->nombre }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tipo de Envase</label>
                                        <select class="form-control" name="fk_tipo_envase">
                                                <option class="form-control" value="I">Seleccione</option>
                                                @foreach ( $tiposEnvase as $tipoEnvase )
                                                    <option class="form-control" value="{{ $tipoEnvase->id }}" @if( $tipoEnvase -> id == old( 'fk_tipo_envase',$producto->fk_tipo_envase) )  selected @endif>{{ $tipoEnvase->nombre }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tipo de Contenido</label>
                                        <select class="form-control" name="fk_tipo_contenido">
                                                <option class="form-control" value="I">Seleccione</option>
                                                @foreach ( $tiposContenido as $tipoContenido )
                                                    <option class="form-control" value="{{ $tipoContenido->id }}" @if( $tipoContenido -> id == old( 'fk_tipo_contenido',$producto->fk_tipo_contenido) )  selected @endif>{{ $tipoContenido->nombre }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tipo de Paca</label>
                                        <select class="form-control" name="fk_tipo_paca">
                                                <option class="form-control" value="I">Seleccione</option>
                                                @foreach ( $tiposPaca as $tipoPaca )
                                                    <option class="form-control" value="{{ $tipoPaca->id }}" @if( $tipoPaca -> id == old( 'fk_tipo_paca',$producto->fk_tipo_paca ) )  selected @endif>{{ $tipoPaca->nombre }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Bodega al Registrar el Producto</label>
                                        <select class="form-control" name="fk_bodega">
                                                <option class="form-control" value="I">Seleccione</option>
                                                @foreach ( $bodegas as $bodega )
                                                    <option class="form-control" value="{{ $bodega->id }}" @if( $bodega -> id == old( 'fk_bodega',$producto->fk_bodega) )  selected @endif>{{ $bodega->nombre }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <select class="form-control" name="estado">
                                        @if( $producto->estado == 'A' and $producto->estado == old('estado',$producto->estado)  )
                                            <option class="form-control" value="A" selected>Activo</option>
                                            <option class="form-control" value="I">Inactivo</option>
                                        @else
                                            <option class="form-control" value="A">Activo</option>            
                                            <option class="form-control" value="I" selected>Inactivo</option>
                                        @endif    
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-warning">Actualizar Producto</button>
                                <a href="{{ url('/producto') }}" class="btn btn-default">Cancelar</a>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="card card-user">
                        <div class="text-center">
                            <h5>Precio del Producto</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- input con el arreglo de los valores de precio --}}
                                <input type="hidden" name="input_precio" id="input_precio" value="{{ old('input_precio') }}">
                                <input type="hidden" name="input_descripcion_precio" id="input_descripcion_precio" value="{{ old('input_descripcion_precio') }}">
                                <input type="hidden" name="input_nombre_precio" id="input_nombre_precio" value="{{ old('input_nombre_precio') }}">
                                <div class="input-field col s4">
                                    <input type="text" class="form-control" id="precio" onkeypress="return solo_enteros_o_decimales(event)">
                                    <label>Precio</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                            $preciosActuales = Array();
//                                            $preciosActuales = $producto -> preciosVenta()->toArray();
                                        ?>
                                        <div class="form-group">
                                            <select class="form-control selPrecio" name="fk_descripcion_precio" id="descripcion_precio">
                                                    <option class="form-control" value="I">Seleccione</option>
                                                    @foreach ( $descripcionesPrecio as $descripcionPrecio )
                                                        <option class="form-control" value="{{ $descripcionPrecio->id }}" @if( $descripcionPrecio -> id == old( 'fk_descripcion_precio') )  selected @endif>{{ $descripcionPrecio->nombre }}</option>
                                                    @endforeach
                                            </select>
                                            <label>Descripcion del Precio</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-field col s4">
                                    <a title="Agregar precio" onclick="agregar_precio()" class="btn btn-info btn-floating btn-round"><i class="fa fa-plus fa-spin"></i></a>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col s8" id="lista_precio">
                                <table class="striped table-bordered" id="tablePrecio">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Precio</th>
                                            <th>Descripcion</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="registro_precio">
                                        @foreach ( $producto -> preciosVenta() as $precio )
                                            <tr>
                                                <td>{{ $precio -> id }}</td>
                                                <td>{{ $precio -> valor }}</td>
                                                <td>{{ $precio -> nombreDescripcion() -> nombre }}</td>
                                                <td>
                                                    <a class='btn btn-danger btn-icon btn-sm' rel="tooltip" title="Eliminar Precio" onclick="Delete('{{ $precio -> nombreDescripcion() -> nombre }}','{{ $precio -> id }}','precio')">
                                                        <i class='fa fa-times'></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- input con el arreglo de los valores de precio --}}
                    <input type="hidden" name="input_iva" id="input_iva" value="{{ old('input_iva') }}">
                    <input type="hidden" name="input_descripcion_iva" id="input_descripcion_iva" value="{{ old('input_descripcion_iva') }}">
                    <input type="hidden" name="input_nombre_iva" id="input_nombre_iva" value="{{ old('input_nombre_iva') }}">
                        <div class="card card-user">
                            <div class="text-center">
                                <h5>Ivas del Producto</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="input-field col s4">
                                        <input type="text" class="form-control" id="iva" onkeypress="return solo_numeros(event)">
                                        <label>Iva</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control selIva" name="fk_descripcion_iva" id="descripcion_iva">
                                                        <option class="form-control" value="I">Seleccione</option>
                                                        @foreach ( $descripcionesIva as $descripcionIva )
                                                            <option class="form-control" value="{{ $descripcionIva->id }}" @if( $descripcionIva -> id == old( 'fk_descripcion_iva') )  selected @endif>{{ $descripcionIva->nombre }}</option>
                                                        @endforeach
                                                </select>
                                                <label>Descripcion del Iva</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-field col s4">
                                        <a title="Agregar precio" onclick="agregar_iva()" class="btn btn-info btn-floating btn-round"><i class="fa fa-plus fa-spin"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col s8" id="lista_iva">
                                    <table class="striped table-bordered" id="tableIva">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Iva</th>
                                                <th>Descripcion</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="registro_iva">
                                            @foreach ( $producto -> ivasProducto() as $iva )
                                                <tr>
                                                    <td>{{ $iva -> id }}</td>
                                                    <td>{{ $iva -> valor }}%</td>
                                                    <td>{{ $iva -> nombreDescripcion() -> nombre }}</td>
                                                    <td>
                                                        <a class='btn btn-danger btn-icon btn-sm' rel="tooltip" title="Eliminar Iva" onclick="Delete('{{ $iva -> nombreDescripcion() -> nombre}}','{{ $iva -> id }}','iva')">
                                                            <i class='fa fa-times'></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
</div>

@section('scripts')

    <script>
        //cargar valores anteriores de los precios e ivas del producto
        $( document ).ready(function() {
            //volver a cargar la tabla vieja de precios
            var input_precio=$('#input_precio').val();
            var input_descripcion_precio=$('#input_descripcion_precio').val();
            var input_nombre_precio=$('#input_nombre_precio').val();
            var lista_precio=$('#lista_precio');
            var registro_precio=$('#registro_precio');
            if( input_precio != "" ) {
                var arrayPrecio = input_precio.split(",");
                var arrayDescripcion = input_descripcion_precio.split(",");
                var arrayNombre = input_nombre_precio.split(",");
                lista_precio.show();
                for( var i = 0 ; i < arrayPrecio.length ; i++ ) {
                    registro_precio.append(
                        '<tr>'+
                            '<td>'+arrayPrecio[i]+'</td>'+
                            '<td>'+arrayNombre[i]+'</td>'+
                        '</tr>'
                    );
                }
            }
            else {
                // // var preciosIniciales = new Array();
                // var elementos = {{ count( $producto -> preciosVenta() ) }};
                // // var preciosIniciales = {{ $producto -> preciosVenta() }};
                // alert( 'elemento ' + elementos );
            }
            //volver a cargar la tabla vieja de ivas
            var lista_iva=$('#lista_iva');
            var registro_iva=$('#registro_iva');
            var input_iva=$('#input_iva');
            var input_descripcion_iva=$('#input_descripcion_iva');
            var input_nombre_iva=$('#input_nombre_iva').val();
            if( input_iva.val() != "" ) {
                var arrayIva = input_iva.val().split(",");
                var arrayDescripcion2 = input_descripcion_iva.val().split(",");
                var arrayNombre2 = input_nombre_iva.split(",");
                lista_iva.show();
                for( var i = 0 ; i < arrayIva.length ; i++ ) {
                    registro_iva.append(
                        '<tr>'+
                            '<td>'+arrayIva[i]+'</td>'+
                            '<td>'+arrayNombre2[i]+'</td>'+
                        '</tr>'
                    );
                }
            }
            // ocultar las opciones de los selects si ya traen datos de productos en precios
            var preciosActuales = <?php echo $producto -> preciosVenta(); ?>; //obtenemos los precios actuales de producto
            $(".selPrecio option").each(function() { // recorrer todo un select
                if( estaIdEnPrecio( $(this).attr('value'), preciosActuales ) ) {
                    $('.selPrecio option[value="'+$(this).attr('value')+'"]').remove();
                }
            });
            // ocultar las opciones de los selects si ya traen datos de productos en ivas
            var ivasActuales = <?php echo $producto -> ivasProducto(); ?>; //obtenemos los precios actuales de producto
            console.log( ivasActuales );
            $(".selIva option").each(function() {
                if( estaIdEnIva( $(this).attr('value'), ivasActuales ) ) {
                    console.log( 'si esta' );
                    $('.selIva option[value="'+$(this).attr('value')+'"]').remove();
                }
            });
        });

        // validar si una id se encuentra en el array
        function estaIdEnPrecio( id, array ) {
            for( var i = 0 ; i < array.length ; i++ ) {
                if( id == array[ i ].fk_descripcion_precio ) {
                    return true;
                }
            }
            return false;
        }

        // validar si una id se encuentra en el array
        function estaIdEnIva( id, array ) {
            for( var i = 0 ; i < array.length ; i++ ) {
                if( id == array[ i ].fk_descripcion_iva ) {
                    return true;
                }
            }
            return false;
        }

        //validar que se digite solo numeros
        function solo_numeros(e){
            var key = window.Event ? e.which : e.keyCode 
            return ((key >= 48 && key <= 57) || (key==8)) 
        }

        //validar que se digite solo numeros enteros o decimales
        function solo_enteros_o_decimales(e){
            var key = window.Event ? e.which : e.keyCode
            return ( (key >= 48 && key <= 57) || (key==8) || ( key == 44 ) );
        }

        //agregar precios a la tabla
        function agregar_precio()
        {
            var precio=$('#precio');
            var precioCompra=$('#precio_compra');
            var descripcion_precio=$('#descripcion_precio');
            var nombre_precio = $("#descripcion_precio option:selected").text();//obtener texto del select
            var lista_precio=$('#lista_precio');
            var registro_precio=$('#registro_precio');
            var input_precio=$('#input_precio');
            var input_descripcion_precio=$('#input_descripcion_precio');
            var input_nombre_precio=$('#input_nombre_precio');
            var arrayPrecio=new Array();
            var arrayDescripcion=new Array();
            var arrayNombre=new Array();
            if( input_precio.val() != "" ) {
                $('input[name^="input_precio"]').each(function() {
                    arrayPrecio.push( $(this).val() );
                });
                $('input[name^="input_descripcion_precio"]').each(function() {
                    arrayDescripcion.push( $(this).val() );
                });
                $('input[name^="input_nombre_precio"]').each(function() {
                    arrayNombre.push( $(this).val() );
                });
            }

            if (precio.val()=="") 
            {
                alert('Debes ingresar el precio!');
                precio.focus();
            }
            else
            {
                if (descripcion_precio.val()=="I") 
                {
                    alert('Debes agregar la descripcion del precio');
                    descripcion_precio.focus();
                }
                else
                {
                    if( parseInt(precioCompra.val()) == 0 || precioCompra.val() == "" ) {
                        alert('Debe ingresar primero el precio de Compra del producto');
                        precio.val('');
                        descripcion_precio.val('I');
                    }
                    else {
                        if( parseInt(precio.val()) <= parseInt(precioCompra.val()) ) {
                            alert('El precio de Venta '+precio.val() +'  debe ser mayor al de Compra ' + precioCompra.val() );
                        }
                        else {
                            lista_precio.show();
                            registro_precio.append(
                                        '<tr>'+
                                            '<td></td>'+
                                            '<td>'+precio.val()+'</td>'+
                                            '<td>'+nombre_precio+'</td>'+
                                            '<td></td>'+
                                        '</tr>'

                            );
                            arrayPrecio.push( precio.val() ); //agrego numero al final del arreglo
                            arrayDescripcion.push( descripcion_precio.val() );
                            arrayNombre.push( nombre_precio );
                            input_precio.val( arrayPrecio );
                            input_descripcion_precio.val( arrayDescripcion );
                            input_nombre_precio.val( arrayNombre );
                            precio.val('');
                            $('.selPrecio').each(function(){
                                $('.selPrecio option[value="'+descripcion_precio.val()+'"]').remove();
                            });
                            descripcion_precio.val('I');
                        }
                    }
                    
                }
            }

        }

        //agregar ivas a la tabla
        function agregar_iva()
        {
            
            var iva=$('#iva');
            var descripcion_iva=$('#descripcion_iva');
            var nombre_iva = $("#descripcion_iva option:selected").text();//obtener texto del select
            var lista_iva=$('#lista_iva');
            var registro_iva=$('#registro_iva');
            var input_iva=$('#input_iva');
            var input_descripcion_iva=$('#input_descripcion_iva');
            var input_nombre_iva=$('#input_nombre_iva');
            var arrayIva=new Array();
            var arrayDescripcion=new Array();
            var arrayNombre = new Array();
            if( input_iva.val() != "" ) {
                $('input[name^="input_iva"]').each(function() {
                    arrayIva.push( $(this).val() );
                });
                $('input[name^="input_descripcion_iva"]').each(function() {
                    arrayDescripcion.push( $(this).val() );
                });
                $('input[name^="input_nombre_iva"]').each(function() {
                    arrayNombre.push( $(this).val() );
                });
            }

            if (iva.val()=="") 
            {
                alert('Debes ingresar el iva!');
                iva.focus();
            }
            else
            {
                if (descripcion_iva.val()=="I") 
                {
                    alert('Debes agregar la descripcion del iva');
                    descripcion_iva.focus();
                }
                else
                {
                lista_iva.show();
                registro_iva.append(
                                '<tr>'+
                                    '<td></td>'+
                                    '<td>'+iva.val()+'%</td>'+
                                    '<td>'+nombre_iva+'</td>'+
                                    '<td></td>'+
                                '</tr>'

                    );
                    arrayIva.push( iva.val() ); //agrego numero al final del arreglo
                    arrayDescripcion.push( descripcion_iva.val() );
                    arrayNombre.push( nombre_iva );
                    input_iva.val( arrayIva );
                    input_descripcion_iva.val( arrayDescripcion );
                    input_nombre_iva.val( arrayNombre );
                    iva.val('');
                    $('.selIva').each(function(){
                        $('.selIva option[value="'+descripcion_iva.val()+'"]').remove();
                    });
                    descripcion_iva.val('I');
                }
            }

        }
    </script>
    <script>
        function Delete( nameProduct , idDel , tipo ) {
            var filasPrecios = $("#tablePrecio tr").length-1;//hay que restar 1 porque es el encabezado
            var filasIvas = $("#tableIva tr").length-1;
            if( filasPrecios > 1 || filasIvas > 1 ) {
                var pathname = window.location.pathname; //ruta actual
                $.confirm({
                    theme: 'supervan',
                    title: 'Eliminar Precio O Iva',
                    content: 'Seguro(a) que deseas eliminar el precio o iva' + nameProduct + '. <br> Click Aceptar or Cancelar',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    animationBounce: 2.5,
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Aceptar',
                            btnClass: 'btn-blue',
                            action: function () {
                                $.confirm({
                                    theme: 'supervan',
                                    title: 'Estas Seguro ?',
                                    content: 'Una vez eliminado debes volver a crear el precio o iva',
                                    icon: 'fa fa-warning',
                                    animation: 'scale',
                                    animationBounce: 2.5,
                                    closeAnimation: 'zoom',
                                    buttons: {
                                        confirm: {
                                            text: 'Si, Estoy Seguro!',
                                            btnClass: 'btn-orange',
                                            action: function () {
                                                $.ajax({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    type: "POST",
                                                    url: "/producto/precio_o_iva/eliminar",
                                                    dataType: "json",
                                                    data: {'id':idDel,'tipo':tipo},
                                                    success: function( msg ){
                                                        $.confirm({
                                                            title: 'Confirmar!',
                                                            content: msg.msg,
                                                            buttons: {
                                                                'confirm': {
                                                                    text: 'Ok',
                                                                    btnClass: 'btn-orange',
                                                                    action: function () {
                                                                        location.reload();
                                                                    }
                                                                },
                                                            }
                                                        });
                                                    }
                                                }); 
                                                // $('.delete').attr('action' , pathname + '/' + idDel );
                                                // $('.delete').submit();
                                            }
                                        },
                                        cancel: {
                                            text: 'No, Cancelar',
                                            //$.alert('you clicked on <strong>cancel</strong>');
                                        }
                                    }
                                });
                            }
                        },
                        cancel: {
                            text: 'Cancelar',
                            //$.alert('you clicked on <strong>cancel</strong>');
                        },
                    }
                });
            }
            else {
                $.alert({
                    title: 'Alerta!',
                    content: 'No pueden haber productos sin al menos un iva o un precio',
                });
            } 
		}
    </script>

@endsection

@endsection