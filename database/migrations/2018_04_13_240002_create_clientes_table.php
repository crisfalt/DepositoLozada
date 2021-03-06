<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->string('number_id', 30)->primary()->unique();
            // $table->increments('id');
            $table->string('name', 150); //nombres
            // $table->string('last_name_pattern',150); //apellido Paterno se separan para los filtrados en campos
            // $table->string('last_name_mattern',150); //apellidos Materno se separan para los filtrados en campos
            //inicio llave foranea a el tipo de documento
            $table->integer('tipo_documento_id')->unsigned();
            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documentos');
            //fin
            $table->string('phone', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('address', 150);
            $table->string('email')->unique()->nullable();
            $table->double('valor_credito', 12, 2);
            $table->string('url_foto', 500);
            //inicio llave foranea a la bodega
            $table->integer('bodega_id')->unsigned();
            $table->foreign('bodega_id')->references('id')->on('bodegas');
            //fin
            //inicio llave foranea a la ruta
            $table->integer('ruta_id')->unsigned();
            $table->foreign('ruta_id')->references('id')->on('rutas');
            //fin
            $table->string('estado', 1)->default('A');
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
        Schema::dropIfExists('clientes');
    }
}
