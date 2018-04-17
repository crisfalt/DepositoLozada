<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagenesProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagenes_productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url_imagen');
            //inicio foreign key
            $table->string('fk_producto',100);//foranea a autoincremental
            $table->foreign('fk_producto')->references('codigo')->on('productos');//id campo primario de tabla padre categories nombre tabla padre
            //fin foreignkey
            $table->boolean('featured')->default(false);//default de una columna
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
        Schema::dropIfExists('imagenes_productos');
    }
}
