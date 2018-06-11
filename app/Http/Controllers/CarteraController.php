<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venta;

class CarteraController extends Controller
{
    public function index() {
        $facTuras = Venta::orderBy('id') -> get();
        return view('admin.cartera.index')->with(compact('facTuras')); //listado de formapago
    }
    public function searchVentas($idcedula) {
		$municipios = municipio::where( 'fk_departamentos', $idDepa )->get();
		return response()->json($municipios);
	}
}
