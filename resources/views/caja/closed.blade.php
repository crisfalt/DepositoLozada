@extends('layouts.app')

@section('title','Cajas')

@section('titulo-contenido','Cajas')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Entradas de Dinero</h5>
            </div>
            <div class="card-body">
                <!-- cargar los filtros de entradas y salidas de dinero -->
                <?php 
                    $totalEntrada = 0;
                ?>
                <table class="display nowrap" cellspacing="0" width="100%" id="">
                    <thead class=" text-primary">
                        <th class="text-left">
                            Fecha
                        </th>
                        <th width="350px">
                            Descripcion
                        </th>
                        <th>
                            Valor
                        </th>
                    </thead>
                    <tbody>
                    @foreach( $entradas as $entrada )
                        <?php 
                            $totalEntrada +=  $entrada -> valor;
                        ?>
                        <tr>
                            <td>{{ $entrada -> fecha }}</td>
                            <td width="350px">{{ $entrada -> descripcion }}</td>
                            <td>{{ $entrada -> valor }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br>
                <h6 class="title">Valor Total de Entradas en la Caja : <strong class="text-danger">${{ $totalEntrada }}</strong></h6>    
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Salidas de Dinero</h5>
            </div>
            <div class="card-body">
                <?php 
                    $totalSalida = 0;
                ?>
                <!-- cargar los filtros de entradas y salidas de dinero -->
                <table class="display nowrap" cellspacing="0" width="100%" id="table_salidas">
                    <thead class=" text-primary">
                        <th class="">
                            Fecha
                        </th>
                        <th width="350px">
                            Descripcion
                        </th>
                        <th class="">
                            Valor
                        </th>
                    </thead>
                    <tbody>
                    @foreach( $salidas as $salida )
                        <?php 
                            $totalSalida +=  $salida -> valor;
                        ?>
                        <tr>
                            <td class="">{{ $salida -> fecha }}</td>
                            <td class="" width="350px">{{ $salida -> descripcion }}</td>
                            <td class="">{{ $salida -> valor }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br>
                <h6 class="title">Valor Total de Salidas en la Caja : <strong class="text-danger">${{ $totalSalida }}</strong></h6>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Dinero en Caja <?php echo date("d-m-Y");?></h5>
                <div class='row'>
                    <div class='col-md-12 text-center'>
                        <!-- <button class="btn btn-round btn-info">Cerrar Caja</button> -->

                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- cargar los filtros de entradas y salidas de dinero -->
                <h4 class="title text-center">Valor Total en Caja : <strong class="text-danger">${{ $totalEntrada - $totalSalida }}</strong></h4>
            </div>
        </div>
    </div>
</div>
@endsection