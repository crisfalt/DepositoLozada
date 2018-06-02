<?php

namespace App;
use App\compra;

use Illuminate\Database\Eloquent\Model;

class abonoCompra extends Model
{
    public static $messages = [
        'valor.required' => 'El campo valor  es  obligatorio',
        'valor.numeric' => 'El campo valor es numerico',
        'fecha.required' => 'El campo fecha se requiere',        
        'fk_compra.required' => 'necesita selecionar el numero de factura'
        
    ];

    public static $rules = [
            'valor' => 'required|numeric',
            'fecha' => 'required',
            'fk_compra' => 'required'
    ];

    public function totalventa() 
        {
        return  compra::where( 'id' , $this -> fk_compra) -> first();
        }
}
