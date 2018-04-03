<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoMovimiento;

class TipoMovimientoController extends Controller
{
    //
    public function index() {
        $tipoMovimiento = TipoMovimiento::orderBy('nombre') -> get();
        return view('admin.tipomovimiento.index')->with(compact('tipoMovimiento')); //listado de tipos movimientos
    }

}
