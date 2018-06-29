<?php

namespace App\Http\Controllers;

use App\Ruta;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getVendedor() {
        $vendedor_id = $_POST['vendedor_id'];
        if( empty($vendedor_id) ) {
            $response = array(
                'status' => false,
                'msg' => 'la id del vendedor esta vacio'
            );
            return response()->json($response);
        }
        $rutas=Ruta::where('estado','A')->where('user_id',$vendedor_id)->with('zona')->get();
        if( count($rutas) == 0 ) {
            $response = array(
                'status' => false,
                'msg' => 'El vendedor no tiene rutas asignadas'
            );
            return response()->json($response);
        }
        $response = array(
            'status' => true,
            'msg' => 'Vendedor encontrado',
            'rutas' => $rutas
        );
        return response()->json($response);
    }
}
