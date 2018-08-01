<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToPreciosProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('precios_productos', function($table) {
            $table -> integer('fk_descripcion_precio')->unsigned(); //se deja nullable para el administsrador pero en la vista se debe pedir como requerido
            $table -> foreign('fk_descripcion_precio')->references('id')->on('descripcion_precios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('precios_productos', function($table) {
            $table ->dropColumn([
                'fk_descripcion_precio'
            ]);
        });
    }
}
