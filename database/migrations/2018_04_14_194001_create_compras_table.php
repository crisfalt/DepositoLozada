<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_compra')->nullable();
            $table->double('total',12,2)->nullable();


            //foranea a estado_compra
            $table->integer('fk_estado_compra')->unsigned();
            $table->foreign('fk_estado_compra')->references('id')->on('estado_compras');
            //fin foranea
            //foranea a formapago
            $table->integer('fk_forma_pago')->unsigned();
            $table->foreign('fk_forma_pago')->references('id')->on('formapagos');
            //fin foranea
            //foranea a proovedor
            $table->string('fk_proveeedors',100);
            $table->foreign('fk_proveeedors')->references('number_id')->on('proveedors');
            //fin foranea
            ////foranea a bodega
            $table->integer('fk_bodega')->unsigned();
            $table->foreign('fk_bodega')->references('id')->on('bodegas');
            //fin foranea
            $table->string('refcompra',100)->nullable();
            $table->double('saldo',12,2)->nullable();

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
        Schema::dropIfExists('compras');
    }
}
