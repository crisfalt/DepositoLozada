<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDetalleCompra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalle_compras', function($table) {
            $table -> integer('Numero_canasta') -> nullable(); //se deja nullable para el administsrador pero en la vista se debe pedir como requerido
            $table->integer('fk_tipo_paca')->unsigned();//foranea a autoincremental
            $table->foreign('fk_tipo_paca')->references('id')->on('tipo_pacas'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
     

        Schema::table('detalle_compras', function($table) {
            $table ->dropColumn([
                'Numero_canasta'
            ]);
        });
        Schema::table('detalle_compras', function($table) {
            $table ->dropColumn([
                'fk_tipo_paca'
            ]);
        });

    }
}
