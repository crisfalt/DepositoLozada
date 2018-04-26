<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDireccionesClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direcciones_clientes', function (Blueprint $table) {
            $table->increments('id');
            //inicio llave foranea a cliente
            $table->integer('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('number_id')->on('clientes');
            //fin
            $table->string('address',150);
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
        Schema::dropIfExists('direcciones_clientes');
    }
}
