<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('nombre', 45);
            //FORANEA LA TABLA DEPARTAMENTO
            $table->string('fk_departamento', 10);
            $table->foreign('fk_departamento')->references('id')->on('departamentos');
            //FIN DE LA FORANEA
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
        Schema::dropIfExists('municipios');
    }
}
