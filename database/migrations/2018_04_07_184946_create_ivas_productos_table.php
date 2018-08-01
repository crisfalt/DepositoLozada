<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIvasProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ivas_productos', function (Blueprint $table) {
            $table->increments('id');
            //foranea a producto
            $table->string('fk_producto',100);
            $table->foreign('fk_producto')->references('codigo')->on('productos');
            //fin foranea
            $table->double('valor',12,2);
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
        Schema::dropIfExists('ivas_productos');
    }
}
