<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->string('number_id',30)->primary()->unique();
            // $table->increments('id');
            $table->string('name',150); //nombres 
            // $table->string('last_name_pattern',150); //apellido Paterno se separan para los filtrados en campos 
            // $table->string('last_name_mattern',150); //apellidos Materno se separan para los filtrados en campos 
            //inicio llave foranea a el tipo de documento
            $table->integer('tipo_documento_id')->unsigned();
            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documentos');
            //fin
            $table->string('address',150);
            $table->string('phone',20);
            $table->string('celular',20)->nullable();
            $table->string('email')->unique()->nullable();
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
        Schema::dropIfExists('proveedors');
    }
}
