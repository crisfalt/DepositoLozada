<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbonoComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abono_compras', function (Blueprint $table) {
           

            $table->increments('id');
            $table->double('valor',12,2)->nullable();
            $table->date('fecha')->nullable();
            $table->string('estado',1)->default('A');
            //inicio foreign abonos->compra
            $table->integer('fk_compra')->unsigned();//foranea a autoincremental
            $table->foreign('fk_compra')->references('id')->on('compras');

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
        Schema::dropIfExists('abono_compras');
    }
}
