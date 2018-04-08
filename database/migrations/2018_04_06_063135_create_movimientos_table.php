<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->time('hora');
            // //foranea a los tipos de movimientos
            // $table->integer('fk_tipo_movimiento')->unsigned();
            // $table->foreign('fk_tipo_movimiento')->references('id')->on('tipo_movimientos');
            //foranea a bodega donde sale el producto
            $table->integer('fk_bodega_entrada')->unsigned();
            $table->foreign('fk_bodega_entrada')->references('id')->on('bodegas');
            //foranea a bodega donde entra el producto
            $table->integer('fk_bodega_salida')->unsigned();
            $table->foreign('fk_bodega_salida')->references('id')->on('bodegas');
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
        Schema::dropIfExists('movimientos');
    }
}
