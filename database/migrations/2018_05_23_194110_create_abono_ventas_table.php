<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbonoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abono_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->double('valor',12,2)->nullable();
            $table->date('fecha')->nullable();
            $table->string('estado',1)->default('A');
            //inicio foreign abonos->ventas
            $table->integer('fk_venta')->unsigned();//foranea a autoincremental
            $table->foreign('fk_venta')->references('id')->on('ventas');//id campo primario de tabla padre categories nombre tabla padre

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
        Schema::dropIfExists('abono_ventas');
    }
}
