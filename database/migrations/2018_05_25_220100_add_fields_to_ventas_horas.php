<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddFieldsToVentasHoras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ventas', function ($table) {
            $table->time('hora')->nullable(); //se deja nullable para el administsrador pero en la vista se debe pedir como requerido
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ventas', function ($table) {
            $table->dropColumn([
                'hora',
            ]);
        });
    }
}
