<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ImagenesProducto;
use App\TipoContenido;
use App\TipoPaca;
use App\SizeBotella;

class Producto extends Model
{

    protected $primaryKey = 'codigo';
    public $incrementing = false; //para quitar el autoincrement

    //
    public static $messages = [
        'codigo.required' => 'El codigo es un campo obligatorio',
        'codigo.min' => 'El codigo debe tener minimo 3 caracteres',
        'codigo.max' => 'El codigo debe tener maximo 100 caracteres',
        'codigo.unique' => 'El codigo que ingresaste ya existe',
        'nombre.required' => 'El nombre es un campo obligatorio',
        'nombre.min' => 'El nombre debe tener minimo 3 caracteres',
        'nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        'descripcion.max' => 'La descripcion debe tener maximo 300 caracteres',
        // 'cantidad.required' => 'La cantidad es un campo obligatorio',
        'cantidad.min' => 'La cantidad debe ser mayor a cero (0)',
        'cantidad.numeric' => 'La cantidad solo acepta numeros',
        'cantidad_reserva.required' => 'La cantidad es un campo obligatorio',
        'cantidad_reserva.min' => 'La cantidad debe ser mayor a cero (0)',
        'cantidad_reserva.numeric' => 'La cantidad solo acepta numeros',
        'precio_compra.required' => 'El precio es un campo obligatorio',
        'precio_compra.between' => 'el precio debe tener entre cero (0) a (8) numeros',
        'precio_compra.digits_between' => 'el precio debe tener digitos entre cero (0) a dos (2)',
        'precio_compra.numeric' => 'El precio solo acepta numeros',
        'fk_marca.required' => 'La marca es un campo obligatorio',
        'fk_size.required' => 'El Tamaño del producto es un campo obligatorio',
        'fk_tipo_envase.required' => 'El tipo de envase es un campo obligatorio',
        'fk_tipo_contenido.required' => 'El tipo de contenido es un campo obligatorio',
        'fk_tipo_paca.required' => 'El tipo de paca es un campo obligatorio',
        'fk_bodega.required' => 'La Bodega es un campo obligatorio',
        'estado.required' => 'El estado es un campo obligatorio',
        'input_precio.required' => 'El Producto debe tener al menos 1 precio',
        'input_iva.required' => 'El Producto debe tener al menos 1 iva'
    ];

    public static $rules = [
            'codigo' => 'required|min:3|max:100|unique:productos,codigo',
            'nombre' => 'required|min:3|max:100|',
            'descripcion' => 'max:300',
            'cantidad' => 'numeric|min:0',
            'cantidad_reserva' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|between:0,99999999',
            'fk_marca' => 'required',
            'fk_size' => 'required',
            'fk_tipo_envase' => 'required',
            'fk_tipo_contenido' => 'required',
            'fk_tipo_paca' => 'required',
            'fk_bodega' => 'required',
            'estado' => 'required',
            'input_precio' => 'required',
            'input_iva' => 'required'
    ];


    //reglas y validaciones actualizacion
    public static $messages2 = [
        'nombre.required' => 'El nombre es un campo obligatorio',
        'nombre.min' => 'El nombre debe tener minimo 3 caracteres',
        'nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        'descripcion.max' => 'La descripcion debe tener maximo 300 caracteres',
        // 'cantidad.required' => 'La cantidad es un campo obligatorio',
        'cantidad.min' => 'La cantidad debe ser mayor a cero (0)',
        'cantidad.numeric' => 'La cantidad solo acepta numeros',
        'cantidad_reserva.required' => 'La cantidad es un campo obligatorio',
        'cantidad_reserva.min' => 'La cantidad debe ser mayor a cero (0)',
        'cantidad_reserva.numeric' => 'La cantidad solo acepta numeros',
        'precio_compra.required' => 'El precio es un campo obligatorio',
        'precio_compra.between' => 'el precio debe tener entre cero (0) a (8) numeros',
        'precio_compra.digits_between' => 'el precio debe tener digitos entre cero (0) a dos (2)',
        'precio_compra.numeric' => 'El precio solo acepta numeros',
        'fk_marca.required' => 'La marca es un campo obligatorio',
        'fk_size.required' => 'El Tamaño del producto es un campo obligatorio',
        'fk_tipo_envase.required' => 'El tipo de envase es un campo obligatorio',
        'fk_tipo_contenido.required' => 'El tipo de contenido es un campo obligatorio',
        'fk_tipo_paca.required' => 'El tipo de paca es un campo obligatorio',
        'fk_bodega.required' => 'La Bodega es un campo obligatorio',
        'estado.required' => 'El estado es un campo obligatorio'
    ];

    public static $rules2 = [
            'nombre' => 'required|min:3|max:100|',
            'descripcion' => 'max:300',
            'cantidad' => 'numeric|min:0',
            'cantidad_reserva' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|between:0,99999999',
            'fk_marca' => 'required',
            'fk_size' => 'required',
            'fk_tipo_envase' => 'required',
            'fk_tipo_contenido' => 'required',
            'fk_tipo_paca' => 'required',
            'fk_bodega' => 'required',
            'estado' => 'required'
    ];

    public function marca() {
//        return $marca = Marca::where('id',$this->fk_marca) -> first();
        return $this->belongsTo('App\Marca','fk_marca');
    }
    
    public function size() {
        return $size = SizeBotella::where('id',$this->fk_size) -> first();
    }

    public function tipoEnvase() {
        return $tipoEnvase = TipoEnvase::where('id',$this->fk_tipo_envase) -> first();
    }

    public function tipoContenido() {
        return $this->belongsTo('App\TipoContenido','fk_tipo_contenido');
//        return $tipoContenido = TipoContenido::where('id',$this->fk_tipo_contenido) -> get();
    }

    public function tipoPaca() {
        return $this->belongsTo(TipoPaca::class,'fk_tipo_paca');
//        return $tipoPaca = TipoPaca::where('id',$this->fk_tipo_paca) -> first();
    }

    public function bodega() {
        return $bodega = Bodega::where('id',$this->fk_bodega) -> first();
    }

    public function preciosVenta() {
//        dd( PreciosProducto::where('fk_producto',$this->codigo)->get() );
        return PreciosProducto::where('fk_producto',$this->codigo)->get();
    }

    public function ivasProducto() {
        return IvasProductos::where('fk_producto',$this->codigo)->get();
    }

    // imagenes de un producto
    public function imagenes() {
        return $imagenes = ImagenesProducto::where('fk_producto',$this->codigo) -> orderBy('featured','desc') -> get(); //para mostrar las imagenes ordenadas por las destacada
    }

}
