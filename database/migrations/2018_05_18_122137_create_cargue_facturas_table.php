<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargueFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargue_facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('venta_id');
            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->integer('cargue_id');
            $table->foreign('cargue_id')->references('id')->on('cargues');
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
        Schema::dropIfExists('cargue_facturas');
    }
}
