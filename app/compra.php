<?php

namespace App;
use App\EstadoCompra;
use App\Proveedor;
use App\formapago;
use App\User;


use Illuminate\Database\Eloquent\Model;

class compra extends Model
{
    public static $messages = [
        
        
        'fk_estado_compra.required' => 'el estado de la compra obligatorio',
        'fk_forma_pago.required' => 'la forma de pago es un campo obligatorio',
        'fk_proveeedors.required' => 'El proveedor es un campo obligatorio',
        'fk_bodega.required' => 'La Bodega es un campo obligatorio',
        'refcompra.required' => 'La referencia de compra es un campo obligatorio'
        
    ];

    public static $rules = [
            
            'fk_estado_compra' => 'required',
            'fk_forma_pago' => 'required',
            'fk_proveeedors' => 'required',
            'fk_bodega' => 'required',
            'refcompra' => 'required'
           
    ];

    //no estamn ahciendo validaciones de compras ?¿

        // compra esta mal debe ser pascalCase es decir asi Compra detalle_compra esta camel debe ser pascal
    
    //
    public function estadoCompras() {
        //trae es todod el objeto vacio ese 
        // dd( EstadoCompra::where( 'id' , $this -> fk_estado_compra) -> first() );
        return EstadoCompra::where( 'id' , $this -> fk_estado_compra) -> first();
    }

    //proveedor con nit no puede ser siempre , hay casios que un proveedor puede ser persona natural
    public function proveedors() {
        return  Proveedor::where( 'number_id' , $this -> fk_proveeedors) -> first();
    }
    public function formapagos() 
    {
     return  formapago::where( 'id' , $this -> fk_forma_pago) -> first();
    }
    public function vendedores() 
     {
        return  User::where( 'id' , $this -> fk_vendedor) -> first();
    }
    public function bodegas() 
    {
        return  Bodega::where( 'id' , $this -> fk_bodega) -> first();
    }

}
