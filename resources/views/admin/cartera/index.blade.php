@extends('layouts.app')

@section('title','Catera Clientes')

@section('titulo-contenido','Catera Clientes')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <!-- mostrar mensaje del controlador -->
    @if (session('notification'))

    <div class="alert alert-info alert-with-icon" data-notify="container">
        <button type="button" data-dismiss="alert" aria-label="Close" class="close">
            <i class="now-ui-icons ui-1_simple-remove"></i>
        </button>
        <span data-notify="icon" class="now-ui-icons ui-1_check"></span>
        <span data-notify="message">{{ session('notification') }}</span>
    </div>
    @endif
    <div class="col-md-6">
        <div class="card">
          
            <div class="card-body">

                    <div class="row">
                        <div class="col-md-12 pr-1">
                            <div class="form-group">
                                <label>Cedula</label>
                                <input type="text" onkeypress="return solo_numeros(event)" class="form-control" id="cc" name="cedula" value="{{ old('cedula') }}">
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class="text-center">
                        <button  onclick="vacio()" name="activador" id="btnconsultar" class="btn btn-info">Consultar</button>

                        <a href="{{ url('/cartera') }}" class="btn btn-default">Cancelar</a>
                    </div>
               

            </div>
        </div>
    </div>

     <div class="col-md-6">
        <div class="card">
          
            <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 pr-1">
                            <div class="form-group">
                             <h3 class="text-center">Total Facturas Pagadas</h3>
                            </div>
                        </div>
                        <div class="col-md-6 pr-1">
                            <div class="form-group">
                                <h3 class="text-center"> <p id="show_total">0</p></h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 pr-1">
                            <div class="form-group">
                             <h3 class="text-center">Total Saldos</h3>
                            </div>
                        </div>
                        <div class="col-md-6 pr-1">
                            <div class="form-group">
                                <h3 class="text-center"> <p id="show_saldo">0</p></h3>
                            </div>
                        </div>
                    </div>
             


            </div>
        </div>
    </div>
   
</div>

 
 <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <!--   {{-- <h4 class="card-title"> Simple Table</h4> --}} -->
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" cellspacing="0" id="tableCarteras">
                        <thead class=" text-primary">
                            <th class="text-center">
                                Cedula
                            </th>
                            <th class="text-center">
                                #Factura
                            </th>
                            <th class="text-center">
                                Total
                            </th>
                            <th class="text-center">
                                Saldo
                            </th>
                            <th class="text-center">
                                Abonar
                            </th>
                        
                        </thead>
                        <tbody id="tableCartera">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/dataTables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/responsive.bootstrap4.min.js') }}" type="text/javascript"></script>


    <script>
     btnconsultar.disabled = true;
      function solo_numeros(e){
            var key = window.Event ? e.which : e.keyCode 
            btnconsultar.disabled = false; 
            return ((key >= 48 && key <= 57) || (key==8))
            
        }
        
        function vacio(){
            var formulario = document.getElementById("cc");
            if(document.getElementById("cc").value == "")
            {
                alert("el campo debe tener el numero de cedula del cliente");
                document.getElementById("cc").value="";
                document.getElementById("cc").focus();            
                btnconsultar.disabled = true;

            }
            else{
                traerfacturas();
                btnconsultar.disabled = true;
            }
            
        }
    </script>



    <script type="text/javascript">
         function traerfacturas()
    {
        var idcedula = document.getElementById('cc').value;
        // $("#fkVentas option").remove();
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "/cartera/searchVenta/"+idcedula,
                dataType: 'json',
                success: function( data ){
                    
                    var addTotal = 0;
                    var addSaldo =0; 
                    // console.log(data);

                    if(data.status) {

                     $('#tableCartera').empty();  
  
                        $.each(data.consulta, function (key, ventas) {
                            
                            if (ventas.fk_forma_de_pago == 1 ) {
                                addTotal += ventas.total;
                            }
                            if (ventas.fk_forma_de_pago == 2 ) {
                                addSaldo += ventas.saldo;                               
                          
                                $('#tableCartera').append('<tr><td class="text-center">' + ventas.fk_cliente + '</td> <td class="text-center">'+ ventas.id + '</td> <td class="text-center">' + ventas.total  + '</td><td class="text-center">' + ventas.saldo + '</td>'+ '</td> <td class="text-center"> <form style="margin: 0; padding: 0;" method="post" action="{{ url("/abono/create") }}"> {{ csrf_field() }} <a href="{{ url("/abono/create")}}'+'/'+ventas.id+'" class="btn btn-warning">Abonar</a> </form> </td>');  
                                            
                            }                      
                            
                        });

                    }
                    else {
                        // $('#tableCartera').remove();   
                        // alert(data.msg);
                       

                    }                    
                   
                    $("#show_total").text(addTotal);
                    $("#show_saldo").text(addSaldo);
                    document.getElementById('cc').value="";
                    
                }
            });

    }
    </script>


@endsection