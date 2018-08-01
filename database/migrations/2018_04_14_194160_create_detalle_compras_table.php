<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_compras', function (Blueprint $table) {
            $table->increments('id');
            //foranea a producto
            $table->string('fk_producto',100);
            $table->foreign('fk_producto')->references('codigo')->on('productos');
            //fin foranea
            $table->integer('cantidad')->unsigned();
            $table->double('precio',12,2);
            //foranea a detalle_compras
            $table->integer('fk_compra')->unsigned();
            $table->foreign('fk_compra')->references('id')->on('compras');
            //fin foranea
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
        Schema::dropIfExists('detalle_compras');
    }
}
