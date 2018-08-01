<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallesVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_ventas', function (Blueprint $table) {
            $table->increments('id');
            //inicio foreign key
            $table->integer('fk_factura')->unsigned();//foranea a autoincremental
            $table->foreign('fk_factura')->references('id')->on('ventas');//id campo primario de tabla padre categories nombre tabla padre
            //inicio foreign key
            $table->string('fk_producto', 100);//foranea a autoincremental
            $table->foreign('fk_producto')->references('codigo')->on('productos');//id campo primario de tabla padre categories nombre tabla padre
            $table->integer('fk_tipo_paca')->unsigned();//foranea a autoincremental
            $table->foreign('fk_tipo_paca')->references('id')->on('tipo_pacas');
            $table->integer('cantidad');
            $table->double('precio',12,2);
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
        Schema::dropIfExists('detalles_ventas');
    }
}
