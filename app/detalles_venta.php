<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\Producto;
// use App\EstadoCompra;

class detalles_venta extends Model
{

    public static $messages = [
        // 'fk_factura.required' => 'El factura es un campo obligatorio',
        'fk_producto.required' => 'El producto es un campo obligatorio',
        // 'precio.required' => 'El precio es un campo obligatorio',
        // 'precio.min' => 'La precio debe ser mayor a cero (0)',
        // 'precio.numeric' => 'La precio solo acepta numeros',

        'cantidad.required' => 'El cantidad es un campo obligatorio',
        'cantidad.min' => 'La cantidad debe ser mayor a cero (0)',
        'cantidad.numeric' => 'La cantidad solo acepta numeros',
        // 'fk_precio.numeric'=> 'el precio solo acepta numeros',
        // 'fk_precio.min' => 'el precio debe ser mayor a cero (0)',
        // 'fk_precio.required' => 'el precio es un campo obligatorio',


        'fk_precio.required' =>'el precio es un campo obligatorio'
    ];
    public static $rules = [
        'cantidad' => 'required|numeric|min:0',
        // 'fk_precio' => 'required|numeric|min:1',
        // 'fk_factura' => 'required',
        'fk_producto' => 'required'
       
        
       
    
];
    //
    public function producto() {
        return Producto::where( 'codigo' , $this -> fk_producto  ) -> first();
    }
    public function empaque() {
        return TipoPaca::where( 'id' , $this -> fk_tipo_paca  ) -> first();
    }

    //para obtener la factura la cual tiene los detalles
    public  function ventas() {
        return $this->belongsTo(Venta::class);
    }
   
     public function productoMarca() 
    {

      return Marca::where('id',$this->producto()->fk_marca)->first();
    } 
}
