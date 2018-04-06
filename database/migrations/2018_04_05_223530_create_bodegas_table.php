<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodegasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodegas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->string('direccion',100);
            $table->string('telefono',20);
            $table->string('celular',20)->nullable();
            //INICIO LLAVE FORANEA A MUNICIPIO
            $table->string('fk_municipio',10);
            $table->foreign('fk_municipio')->references('id')->on('municipios');
            //FIN DE LA LLAVE FORANEA
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
        Schema::dropIfExists('bodegas');
    }
}
