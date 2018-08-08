<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Producto;
use App\EstadoCompra;
class detalle_compra extends Model
{
    public static $messages = [
        'cantidad.required' => 'La cantidad es un campo obligatorio',
        'cantidad.min' => 'La cantidad debe ser mayor a cero (0)',
        'cantidad.numeric' => 'La cantidad solo acepta numeros',
       
        'fk_producto.req' => 'El producto se requiere',
        // 'fk_compra.required' => 'no se ha generado codigo compra incie secion nuevamente'
       
       
    ];

    public static $rules = [
            'cantidad' => 'required|numeric|between:0,99999999',            
          
            'fk_producto' =>'required',
            // 'fk_compra' => 'required'
    ];

    public function producto() {
        return Producto::where( 'codigo' , $this -> fk_producto  ) -> first();
    }

    

    public function empaque() {
        return TipoPaca::where( 'id' , $this -> fk_tipo_paca  ) -> first();
    }
    // public function estado() {
    //     return EstadoCompra::where( 'id' , $this -> fk_estado_compra) -> first();
    // }
    public function productoMarca() 
    {

      return Marca::where('id',$this->producto()->fk_marca)->first();
    } 

}
