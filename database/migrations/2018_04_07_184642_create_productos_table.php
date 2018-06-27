<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->string('codigo',100)->primary();
            $table->string('nombre',100);
            $table->string('descripcion',300)->nullable();
            $table->integer('cantidad')->unsigned()->nullable();
            $table->integer('cantidad_reserva');
            $table->double('precio_compra',12,2);
            //inicio atributo foraneo a marca
            $table->integer('fk_marca')->unsigned();
            $table->foreign('fk_marca')->references('id')->on('marcas');
            //fin foranea marca
            //inicio atributo foraneo a tamaño botellas
            $table->integer('fk_size')->unsigned();
            $table->foreign('fk_size')->references('id')->on('size_botellas');
            //fin foranea tamaño botellas
            //inicio atributo foraneo a tipoenvase
            $table->integer('fk_tipo_envase')->unsigned();
            $table->foreign('fk_tipo_envase')->references('id')->on('tipo_envases');
            //fin foranea tipoenvase
            //inicio atributo foraneo a tipocontenido
            $table->integer('fk_tipo_contenido')->unsigned();
            $table->foreign('fk_tipo_contenido')->references('id')->on('tipo_contenidos');
            //fin foranea tipocontenido
            //inicio atributo foraneo a tipo_paca
            $table->integer('fk_tipo_paca')->unsigned();
            $table->foreign('fk_tipo_paca')->references('id')->on('tipo_pacas');
            //fin foranea tipo_paca
            //inicio atributo foraneo a bodega
            $table->integer('fk_bodega')->unsigned();
            $table->foreign('fk_bodega')->references('id')->on('bodegas');
            //fin foranea bodega
            $table->string('estado',1)->default('A');
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
        Schema::dropIfExists('productos');
    }
}
