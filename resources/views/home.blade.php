@extends('layouts.app')

@section('title','alertas')

@section('titulo-contenido','Principal')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <!--   {{-- <h4 class="card-title"> Simple Table</h4> --}} -->
                <a href="{{ url('/venta/0/create') }}" class="btn btn-warning btn-round">crear venta</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" cellspacing="0" id="tableVentas">
                        <thead class=" text-primary">
                            <th class="text-cen ter">
                                Cliente
                            </th>
                             <th class="text-center">
                                N°Venta
                            </th>
                            <th class="text-center">
                                Fecha
                            </th>
                            <th class="text-center">
                                Hora
                            </th>
                            <th class="text-center">
                                Estado venta
                            </th>                            
                            <th class="text-center">
                                Total
                            </th> 
                            <th class="text-center">
                                Saldo
                            </th>                            
                            <th class="text-center">
                                Opciones
                            </th>
                        </thead>
                        <tbody>
                            @foreach( $ventas as $venta )
                                <tr>
                                    <td class="text-center">{{ $venta ->cliente()->name }}</td>
                                    <td class="text-center">{{ $venta -> id }}</td>
                                    @if($venta -> fecha_entrega !=null)
                                    <td class="text-center">{{ $venta -> fecha_entrega }}</td>

                                    @else
                                    <td class="text-center">sin fecha factura</td>
                                    @endif
                                    @if($venta -> hora !=null)
                                    <td class="text-center">{{ $venta -> hora }}</td>

                                    @else
                                    <td class="text-center">sin hora factura</td>
                                    @endif
                                    <td class="text-center">{{ $venta -> estadoventas()->nombre}}</td>  
                                    @if($venta->total != null ||$venta->total != "")                                           
                                    <td class="text-center">{{ $venta -> total }}</td>
                                    @else

                                    <td class="text-center">0</td>
                                    @endif
                                     @if($venta->saldo != null ||$venta->saldo != "")                                           
                                    <td class="text-center">{{ $venta -> saldo }}</td>
                                    @else
                                    
                                    <td class="text-center">0</td>
                                    @endif
                                    
                                    <td class="td-actions text-right">
                                        <form method="post" class="delete">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        
    
                                            <a href="{{ url('/venta/'.$venta->id) }}" rel="tooltip" title="Ver Venta{{ $venta -> id }}" class="btn btn-info btn-simple btn-xs">
                                                <i class="fa fa-info"></i>
                                            </a>
                                           
                                           
                                            @if($venta->fk_estado_venta==1 || $venta->fk_estado_venta==2)
                                            <a href="{{ url('/venta/'.$venta->id.'/edit') }}" rel="tooltip" title="Editar Venta{{ $venta -> id }}" class="btn btn-success btn-simple btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endif
                                            @if(    $venta->fk_estado_venta==1 || $venta->fk_estado_venta==2 && $venta->total==0  )
                                            <a class='btn btn-danger btn-simple btn-xs' rel="tooltip" title="Eliminar venta {{ $venta -> id }}" onclick="Delete('{{ $venta -> id }}','{{ $venta -> id }}')">
                                                    <i class='fa fa-times'></i>
                                            </a>
                                          
                                          @else
                                          @if($venta->fk_estado_venta==3)
                                          <a href="{{ action('VentaController@imprimir',['id' => $venta -> id,'estado'=>0 ]) }}"  class="btn btn-danger btn-xs" target="_blank()">
                                          PDF</a>
                                          @endif
                            
                                          @endif
                                          @if($venta->fk_estado_venta==2)
                                          <a href="{{ action('VentaController@imprimir',['id' => $venta -> id,'estado'=>0 ]) }}"  class="btn btn-danger btn-xs" target="_blank()">
                                          PDF</a>
                                          <a href="{{ action('VentaController@imprimir',['id' => $venta -> id,'estado'=>3 ]) }}"  class="btn btn-success btn-xs" target="_blank()">PDF - Entregar</a>
                                          @endif


                                           
                                            <!-- <button type="submit" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs">
                                                <i class="fa fa-times"></i>
                                            </button> -->
                                        </form>
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
@endsection
