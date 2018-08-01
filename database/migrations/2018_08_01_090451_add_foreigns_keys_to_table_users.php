<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsKeysToTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            //inicio llave foranea a el tipo de documento
            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documentos');
            //fin
            //inicio llave foranea a el tipo de perfil
            $table->foreign('perfil_id')->references('id')->on('perfils');
            //fin
            //inicio llave foranea a la bodega
            $table->foreign('bodega_id')->references('id')->on('bodegas');
            //fin
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table ->dropForeign([
                'com_institucion_id',
                'perfil_id',
                'bodega_id'
            ]);
        });
    }
}
