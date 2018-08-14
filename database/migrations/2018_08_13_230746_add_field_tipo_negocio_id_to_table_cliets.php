<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldTipoNegocioIdToTableCliets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function($table) {
            $table->unsignedInteger('tipo_negocio_id')->after('number_id');
            $table->foreign('tipo_negocio_id')->references('id')->on('tipo_negocios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function($table) {
            $table ->dropForeign([
                'tipo_negocio_id',
            ]);
            $table ->dropColumn([
                'tipo_negocio_id',
            ]);
        });
    }
}
