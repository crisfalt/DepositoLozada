<?php

namespace App;
use App\Venta;

use Illuminate\Database\Eloquent\Model;

class abonoVenta extends Model
{

    public static $messages = [
        'valor.required' => 'El campo valor  es  obligatorio',
        'valor.numeric' => 'El campo valor es numerico',
        'fecha.required' => 'El campo fecha se requiere',        
        'fk_venta.required' => 'necesita selecionar el numero de factura'
        
    ];

    public static $rules = [
            'valor' => 'required|numeric',
            'fecha' => 'required',
            'fk_venta' => 'required'
    ];

    public function totalfactura() 
        {
        return  Venta::where( 'id' , $this -> fk_venta) -> first();
        }
}
