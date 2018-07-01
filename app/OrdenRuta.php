<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cliente;

class OrdenRuta extends Model
{
    //obtener los valores del cliente
    public function cliente() {
        $cliente = Cliente::where('number_id',$this -> cliente_id ) -> first();
//        dd( $cliente );
        return $cliente;
    }

}
