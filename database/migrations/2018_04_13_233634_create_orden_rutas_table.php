<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenRutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_rutas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orden')->unsigned();
            //inicio llave foranea al cliente
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            //fin
            //inicio llave foranea a la ruta
            $table->integer('ruta_id')->unsigned();
            $table->foreign('ruta_id')->references('id')->on('rutas');
            //fin
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
        Schema::dropIfExists('orden_rutas');
    }
}
