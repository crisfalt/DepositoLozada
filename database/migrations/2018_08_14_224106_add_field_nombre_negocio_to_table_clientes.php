<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddFieldNombreNegocioToTableClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function ($table) {
            $table->string('nombre_negocio', 250)->after('ruta_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function ($table) {
            $table->dropForeign([
                'nombre_negocio',
            ]);
            $table->dropColumn([
                'nombre_negocio',
            ]);
        });
    }
}
