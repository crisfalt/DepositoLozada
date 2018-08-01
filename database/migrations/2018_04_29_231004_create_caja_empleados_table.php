<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajaEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_empleados', function (Blueprint $table) {
            $table->increments('id');
            //inicio foranea a caja que realiza el movimiento
            $table->integer('caja_id')->unsigned();
            $table->foreign('caja_id')->references('id')->on('cajas');
            //fin
            //inicio foranea al empleado que realiza el movimiento en una caja
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('caja_empleados');
    }
}
