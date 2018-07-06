<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EstadoDeVenta;
use App\User;
use App\Bodega;
use App\formapago;
use App\Producto;
use App\detalles_venta;
use App\Cliente;
use Illuminate\Support\Facades\DB;

class Venta extends Model
{


    public static $messages = [
        'fk_cliente.required' => 'El Cliente es un campo obligatorio',
        // 'fk_vendedor.required' => 'El vendedor es un campo obligatorio',
        // 'fk_estado_venta.required' => 'El estado es un campo obligatorio',
        'fk_bodega.required' => 'la bodega es un campo obligatorio'
        // 'total.required' => 'El total es un campo obligatorio',
        // 'total.min' => 'La cantidad debe ser mayor a cero (0)',
        // 'total.numeric' => 'La cantidad solo acepta numeros'
     
    ];
    public static $rules = [
        // 'total' => 'required|numeric|min:0',
        'fk_cliente' => 'required',
        // 'fk_estado_venta' => 'required',
        // 'fk_vendedor' => 'required',
        
        'fk_bodega' => 'required'
    
];

  //pryeba de github
  //otra prueba porque la perra no sabe
  public function estadoVentas() {
        //trae es todod el objeto vacio ese 
        // dd( EstadoCompra::where( 'id' , $this -> fk_estado_compra) -> first() );
        return EstadoDeVenta::where( 'id' , $this -> fk_estado_venta) -> first();
    }

    public function detalles_ventas() {
        return $this->hasMany(detalles_venta::class);
    }


//    public function cliente() {
////        return  Cliente::where( 'number_id' , $this -> fk_cliente) -> first();
//        return $this->belongsTo(Cliente::class);
//    }

    public function cliente() {
       return  Cliente::where( 'number_id' , $this -> fk_cliente) -> first();
    }

      public function rutass() 
        {
        
          return  DB::table('rutas')->where('id', $this -> cliente()->ruta_id)-> first();
        }

        public function Zonass() 
        {
        
          return  DB::table('zonas')->where('id', $this -> rutass()->zona_id)-> first();
        }
    
      
      public function vendedores() 
        {
        return  User::where( 'id' , $this -> fk_vendedor) -> first();
        }
      public function municipios() 
        {
        // return  Bodega::where( 'id' , $this -> fk_bodega) -> first();
          return  DB::table('municipios')->where('id', $this -> bodegas()->fk_municipio)-> first();
        }

        public function departamentos() 
        {
        // return  Bodega::where( 'id' , $this -> fk_bodega) -> first();
          return  DB::table('departamentos')->where('id', $this -> municipios()->fk_departamento)-> first();
        }


      public function bodegas() 
        {
        return  Bodega::where( 'id' , $this -> fk_bodega) -> first();
        }
       public function formapagos() 
       {
        return  formapago::where( 'id' , $this -> fk_forma_de_pago) -> first();
       }
      //  public function productoVenta() 
      //  {
      //   return  Producto::where( 'codigo' , $this -> fk_producto) -> first();
      //  }
      
    //
}
