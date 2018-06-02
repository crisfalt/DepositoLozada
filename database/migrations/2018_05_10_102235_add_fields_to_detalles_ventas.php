<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDetallesVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalles_ventas', function($table) {
            $table -> integer('Numero_canasta') -> nullable(); //se deja nullable para el administsrador pero en la vista se debe pedir como requerido
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
         Schema::table('detalles_ventas', function($table) {
            $table ->dropColumn([
                'Numero_canasta'
            ]);
        });
    }
}
