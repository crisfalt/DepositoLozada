<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallesMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_movimientos', function (Blueprint $table) {
            $table->increments('id');
            //foranea al producto a mover
            $table->string('fk_producto',100);
            $table->foreign('fk_producto')->references('codigo')->on('productos');
            $table->integer('cantidad');
            //fin foranea
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_movimientos');
    }
}
