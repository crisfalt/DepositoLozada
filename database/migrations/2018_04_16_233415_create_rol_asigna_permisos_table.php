<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolAsignaPermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rol_asigna_permisos', function (Blueprint $table) {
            $table->increments('id');
            //inicio llave foranea al perfil
            $table->integer('permiso_id')->unsigned();
            $table->foreign('permiso_id')->references('id')->on('permisos');
            //fin
            //inicio llave foranea al rol
            $table->integer('rol_id')->unsigned();
            $table->foreign('rol_id')->references('id')->on('rols');
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
        Schema::dropIfExists('rol_asigna_permisos');
    }
}
