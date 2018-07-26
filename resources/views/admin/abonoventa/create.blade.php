@extends('layouts.app')

@section('title','Abonos')

@section('titulo-contenido','Abonos')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <!-- mostrar mensaje del controlador -->
   
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Crear Nuevo Abono</h5>
            </div>
            <div class="card-body">
                 @if (session('notification'))

                <div class="alert alert-warning alert-with-icon" data-notify="container">
                    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
                        <i class="now-ui-icons ui-1_simple-remove"></i>
                    </button>                   
                    <span data-notify="message">{{ session('notification') }}</span>
                </div>
                @endif
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
                <form method="post" action="{{ url('/abono') }}">
                    {{ csrf_field() }}
                  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label># de Factura</label>
                              
                                <select class="form-control" name="fk_venta" id="fk_venta" onchange="recargarValorVenta()">
                                        <option class="form-control" value="">Seleccione la factura</option>
                                        @foreach ( $ventas as $venta )
                                            <option class="form-control" value="{{ $venta->id }}" @if( $venta -> id == old( 'fk_venta') )  selected @endif>{{ $venta->id }}</option>
                                        @endforeach
                                </select>

                    <script>
                            //pasamos el valor a la lista para dejar selecionado unaf actura 
                           var a ='<?php echo $IdAbono ?>';
                                if( a>0)
                                {                                   
                                    document.getElementById("fk_venta").value =a;
                                    //metodo para carga una funcion apenas se abre la pagina 
                                    window.onload=function()
                                     {
                                         recargarValorVenta();
                                     }

                                }
                                else
                                {                          
                                     document.getElementById("fk_venta").value ="";
                                }                
                    </script>

                              
                                
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Saldo de la Factura</label>                               
                                <select class="form-control" id="numero2" name="saldo" disabled="true">
                                    
                                    
                                     
                                </select>
                                <input type="hidden" id="saldo2" name="saldo2">
                               
                            </div>
                        </div>
                    </div>
                      <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>valor</label>
                                <input type="numeric" id="numero"  class="form-control" name="valor" value="{{ old('valor') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label >Fecha</label>
                                <input type="date" name="fecha" id="datepicker" onchange="validarfecha();" pattern="[_0-9]{2}/[_0-9]{2}/[_0-9]{4}"class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="text-center"> 
                   
                      
                        <button class="btn btn-warning" onclick="validarfecha();validarmayor()">Registrar </button>
                        <a href="{{ url('/abono') }}" class="btn btn-default">Cancelar</a>
                        
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@script 




<script type="text/javascript">
   

    function validarfecha()
    {
        var fecha=document.getElementById("datepicker").value;
        if(fecha=="")
        {
            alert("debe selecionar la fecha");

        }


    }
    
    function validarSiNumero(numero)
      {

        if (!/^([0-9])*$/.test(numero))
        alert("El valor " + numero + " no es un número");
        limpiar();      
      }
    

      function limpiar() 
      {
        document.getElementById("numero").value = "";
        document.getElementById("numero").focus();
      }
//////////////////////////////////////////////////////7
      function recargarValorVenta()
    {
        var saldoventa = document.getElementById('fk_venta').value;
        $("#numero2 option").remove();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "/abono/searchTotal/"+saldoventa,
                dataType: 'json',
                success: function( data ){
                    console.log(data);
                    $.each(data, function (key, saldventa) {
                        
                        if(saldventa.saldo==null ||saldventa.saldo==0)
                        {
                            
                            $("#numero2").append("<option value=" + saldventa.id + ">" +saldventa.total+ "</option>");
                            $("#saldo2").val( saldventa.total );

                        }
                        else
                        {
                            
                            $("#numero2").append("<option value=" + saldventa.id + ">" +saldventa.saldo+ "</option>");
                            $("#saldo2").val( saldventa.saldo );
                        }
                        
                   
                       
                    });

                }
            });

            

    }

    function validarmayor()
    {   
        //capturo el id de lista
        var combo = document.getElementById("numero2");
        //con el id capturado traigo el valor de esa lista
        var saldo = combo.options[combo.selectedIndex].text;
        //capturlo el valor del numero
        var abono = document.getElementById("numero").value;
        if(abono>0)
        {
            
             if(parseFloat(abono)>parseFloat(saldo))
                {
                    alert("usted no puede ingresar una valor mayor al saldo de la factura");
                     document.getElementById("numero").value = "";
                     document.getElementById("numero").focus();
                }
              

        }
        else
        {
            alert("el abono no puede ser cero");
             document.getElementById("numero").value = "";
            document.getElementById("numero").focus();
        }
       
    }


</script>
<!-- <script type="text/javascript">
            $('#datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true,
            startView: 2,
            endDate: "+Infinity"
        });

   
</script> -->

