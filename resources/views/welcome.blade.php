@extends('layouts.app')

@section('title','DepositoLozada | DashBoard')

@section('titulo-contenido' , 'Bienvenido')

@section('header-class')
<div class="panel-header">
    <canvas id="bigDashboardChart"></canvas>
</div>
@endsection

@section('contenido')

<!-- <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Simple Table</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <th>
                                Name
                            </th>
                            <th>
                                Country
                            </th>
                            <th>
                                City
                            </th>
                            <th class="text-right">
                                Salary
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Dakota Rice
                                </td>
                                <td>
                                    Niger
                                </td>
                                <td>
                                    Oud-Turnhout
                                </td>
                                <td class="text-right">
                                    $36,738
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Minerva Hooper
                                </td>
                                <td>
                                    Curaçao
                                </td>
                                <td>
                                    Sinaai-Waas
                                </td>
                                <td class="text-right">
                                    $23,789
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Sage Rodriguez
                                </td>
                                <td>
                                    Netherlands
                                </td>
                                <td>
                                    Baileux
                                </td>
                                <td class="text-right">
                                    $56,142
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Philip Chaney
                                </td>
                                <td>
                                    Korea, South
                                </td>
                                <td>
                                    Overland Park
                                </td>
                                <td class="text-right">
                                    $38,735
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Doris Greene
                                </td>
                                <td>
                                    Malawi
                                </td>
                                <td>
                                    Feldkirchen in Kärnten
                                </td>
                                <td class="text-right">
                                    $63,542
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Mason Porter
                                </td>
                                <td>
                                    Chile
                                </td>
                                <td>
                                    Gloucester
                                </td>
                                <td class="text-right">
                                    $78,615
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Jon Porter
                                </td>
                                <td>
                                    Portugal
                                </td>
                                <td>
                                    Gloucester
                                </td>
                                <td class="text-right">
                                    $98,615
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card card-plain">
            <div class="card-header">
                <h4 class="card-title"> Table on Plain Background</h4>
                <p class="category"> Here is a subtitle for this table</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <th>
                                Name
                            </th>
                            <th>
                                Country
                            </th>
                            <th>
                                City
                            </th>
                            <th class="text-right">
                                Salary
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Dakota Rice
                                </td>
                                <td>
                                    Niger
                                </td>
                                <td>
                                    Oud-Turnhout
                                </td>
                                <td class="text-right">
                                    $36,738
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Minerva Hooper
                                </td>
                                <td>
                                    Curaçao
                                </td>
                                <td>
                                    Sinaai-Waas
                                </td>
                                <td class="text-right">
                                    $23,789
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Sage Rodriguez
                                </td>
                                <td>
                                    Netherlands
                                </td>
                                <td>
                                    Baileux
                                </td>
                                <td class="text-right">
                                    $56,142
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Philip Chaney
                                </td>
                                <td>
                                    Korea, South
                                </td>
                                <td>
                                    Overland Park
                                </td>
                                <td class="text-right">
                                    $38,735
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Doris Greene
                                </td>
                                <td>
                                    Malawi
                                </td>
                                <td>
                                    Feldkirchen in Kärnten
                                </td>
                                <td class="text-right">
                                    $63,542
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Mason Porter
                                </td>
                                <td>
                                    Chile
                                </td>
                                <td>
                                    Gloucester
                                </td>
                                <td class="text-right">
                                    $78,615
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Jon Porter
                                </td>
                                <td>
                                    Portugal
                                </td>
                                <td>
                                    Gloucester
                                </td>
                                <td class="text-right">
                                    $98,615
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Edit Profile</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-5 pr-1">
                            <div class="form-group">
                                <label>Company (disabled)</label>
                                <input type="text" class="form-control" disabled="" placeholder="Company" value="Creative Code Inc.">
                            </div>
                        </div>
                        <div class="col-md-3 px-1">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" placeholder="Username" value="michael23">
                            </div>
                        </div>
                        <div class="col-md-4 pl-1">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pr-1">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" placeholder="Company" value="Mike">
                            </div>
                        </div>
                        <div class="col-md-6 pl-1">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" placeholder="Last Name" value="Andrew">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" placeholder="Home Address" value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 pr-1">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" placeholder="City" value="Mike">
                            </div>
                        </div>
                        <div class="col-md-4 px-1">
                            <div class="form-group">
                                <label>Country</label>
                                <input type="text" class="form-control" placeholder="Country" value="Andrew">
                            </div>
                        </div>
                        <div class="col-md-4 pl-1">
                            <div class="form-group">
                                <label>Postal Code</label>
                                <input type="number" class="form-control" placeholder="ZIP Code">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>About Me</label>
                                <textarea rows="4" cols="80" class="form-control" placeholder="Here can be your description" value="Mike">Lamborghini Mercy, Your chick she so thirsty, I'm in that two seat Lambo.</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-user">
            <div class="image">
                <img src="../assets/img//bg5.jpg" alt="...">
            </div>
            <div class="card-body">
                <div class="author">
                    <a href="#">
                        <img class="avatar border-gray" src="../assets/img//mike.jpg" alt="...">
                        <h5 class="title">Mike Andrew</h5>
                    </a>
                    <p class="description">
                        michael24
                    </p>
                </div>
                <p class="description text-center">
                    "Lamborghini Mercy
                    <br> Your chick she so thirsty
                    <br> I'm in that two seat Lambo"
                </p>
            </div>
            <hr>
            <div class="button-container">
                <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                    <i class="fab fa-facebook-f"></i>
                </button>
                <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                    <i class="fab fa-twitter"></i>
                </button>
                <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                    <i class="fab fa-google-plus-g"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="col-lg-4">
        <div class="card card-chart">
            <div class="card-header">
                <h5 class="card-category">Ventas</h5>
                <h4 class="card-title">Ventas Mensuales</h4>
                <div class="dropdown">
                    <button type="button" class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                        <i class="now-ui-icons loader_gear"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <a class="dropdown-item text-danger" href="#">Remove Data</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="lineChartExample"></canvas>
                </div>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="now-ui-icons arrows-1_refresh-69"></i> Actualizado
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card card-chart">
            <div class="card-header">
                <h5 class="card-category">Compras</h5>
                <h4 class="card-title">Compras Mensuales</h4>
                <div class="dropdown">
                    <button type="button" class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                        <i class="now-ui-icons loader_gear"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <a class="dropdown-item text-danger" href="#">Remove Data</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="lineChartExampleWithNumbersAndGrid"></canvas>
                </div>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="now-ui-icons arrows-1_refresh-69"></i> Actualizado
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card card-chart">
            <div class="card-header">
                <h5 class="card-category">Cargues</h5>
                <h4 class="card-title">Cargues 24 horas</h4>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="barChartSimpleGradientsNumbers"></canvas>
                </div>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="now-ui-icons ui-2_time-alarm"></i> Ultimos 7 Dias
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
    <div class="card card-tasks">
        <div class="card-header">
        <h5 class="card-category">Compromisos de Marzo</h5>
        <h4 class="card-title">Tareas de Marzo</h4>
        </div>
        <div class="card-body">
        <div class="table-full-width table-responsive">
            <table class="table">
            <tbody>
                <tr>
                    <td>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" checked="">
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </td>

                    <td class="text-left">Sign contract for "What are conference organizers afraid of?"</td>
                    <td class="td-actions text-right">
                        <button type="button" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
                            <i class="now-ui-icons ui-2_settings-90"></i>
                        </button>
                        <button type="button" rel="tooltip" title="" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox">
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </td>

                    <td class="text-left">Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                    <td class="td-actions text-right">
                        <button type="button" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
                            <i class="now-ui-icons ui-2_settings-90"></i>
                        </button>
                        <button type="button" rel="tooltip" title="" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" checked="">
                                <span class="form-check-sign"></span>
                            </label>
                        </div>
                    </td>

                    <td class="text-left">Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                    </td>
                    <td class="td-actions text-right">
                        <button type="button" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
                            <i class="now-ui-icons ui-2_settings-90"></i>
                        </button>
                        <button type="button" rel="tooltip" title="" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
        <div class="card-footer">
        <hr>
        <div class="stats">
            <i class="now-ui-icons loader_refresh spin"></i> Se actualizo cada 3 Minutos
        </div>
        </div>
    </div>
    </div>
    <div class="col-md-6">
        <div class="card">
        <div class="card-header">
            <h5 class="card-category">Lista del Personal</h5>
            <h4 class="card-title"> Empleados Actuales</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                <thead class=" text-primary">
                    <th >
                    Nombre
                    </th>
                    <th >
                    Cargo
                    </th>
                    <th >
                    City
                    </th>
                    <th  class="text-right" >
                    Salario
                    </th>
                </thead>
                <tbody>
                    <tr >
                    <td >
                        Dakota Rice
                    </td>
                    <td >
                        Niger
                    </td>
                    <td >
                        Oud-Turnhout
                    </td>
                    <td  class="text-right" >
                        $36,738
                    </td>
                    </tr>
                    <tr >
                    <td >
                        Minerva Hooper
                    </td>
                    <td >
                        Curaçao
                    </td>
                    <td >
                        Sinaai-Waas
                    </td>
                    <td  class="text-right" >
                        $23,789
                    </td>
                    </tr>
                    <tr >
                    <td >
                        Sage Rodriguez
                    </td>
                    <td >
                        Netherlands
                    </td>
                    <td >
                        Baileux
                    </td>
                    <td  class="text-right" >
                        $56,142
                    </td>
                    </tr>
                    <tr >
                    <td >
                        Doris Greene
                    </td>
                    <td >
                        Malawi
                    </td>
                    <td >
                        Feldkirchen in Kärnten
                    </td>
                    <td  class="text-right" >
                        $63,542
                    </td>
                    </tr>
                    <tr >
                    <td >
                        Mason Porter
                    </td>
                    <td >
                        Chile
                    </td>
                    <td >
                        Gloucester
                    </td>
                    <td  class="text-right" >
                        $78,615
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div> -->

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();
    });
</script>
@endsection