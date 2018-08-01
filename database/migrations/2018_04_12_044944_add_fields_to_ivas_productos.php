<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToIvasProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('ivas_productos', function($table) {
            $table -> integer('fk_descripcion_iva')->unsigned(); //se deja nullable para el administsrador pero en la vista se debe pedir como requerido
            $table -> foreign('fk_descripcion_iva')->references('id')->on('descripcion_ivas');
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
        Schema::table('ivas_productos', function($table) {
            $table ->dropColumn([
                'fk_descripcion_iva'
            ]);
        });
    }
}
