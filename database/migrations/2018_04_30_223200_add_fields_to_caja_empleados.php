<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCajaEmpleados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('caja_empleados', function($table) {
            $table->date('fecha');//fecha para ver que dia se le asigno una caja a un ampleado
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('caja_empleados', function($table) {
            $table ->dropColumn([
                'fecha'
            ]);
        });
    }
}
