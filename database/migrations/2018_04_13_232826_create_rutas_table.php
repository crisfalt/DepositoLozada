<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rutas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->string('descripcion',300)->nullable();
            //inicio foranea a zona
            $table->integer('zona_id')->unsigned();
            $table->foreign('zona_id')->references('id')->on('zonas');
            //inicio foranea a usuarios -> tipo vendedor
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            //fin
            $table->string('estado',1)->default('A');
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
        Schema::dropIfExists('rutas');
    }
}
