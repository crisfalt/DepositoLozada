<?php

namespace App\Http\Controllers;

use App\Venta;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fechaAlerta = Carbon::now()->toDateString();

        $ventas = Venta::orderBy('id', 'desc')->where('fecha_entrega', $fechaAlerta)->where('fk_estado_venta', 2)->get();

        return view('home')->with(compact('ventas'));
    }
}
