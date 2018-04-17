<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',300);
            $table->string('address',150);
            $table->string('phone',20);
            $table->string('celular',20);
            $table->string('email')->unique();
            $table->string('password');
            //inicio llave foranea a el tipo de perfil
            $table->integer('perfil_id')->unsigned();
            $table->foreign('perfil_id')->references('id')->on('perfils');
            //fin
            //inicio llave foranea a la bodega
            $table->integer('bodega_id')->unsigned();
            $table->foreign('bodega_id')->references('id')->on('bodegas');
            //fin
            //inicio llave foranea a la ruta
            $table->integer('ruta_id')->unsigned();
            $table->foreign('ruta_id')->references('id')->on('rutas');
            //fin
            $table->string('estado',1) -> default('I');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
