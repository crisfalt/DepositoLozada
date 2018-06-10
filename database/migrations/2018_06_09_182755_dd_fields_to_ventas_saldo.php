<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DdFieldsToVentasSaldo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ventas', function($table) {
            $table -> double('saldo',8,2) -> nullable(); //se deja nullable para el administsrador pero en la vista se debe pedir como requerido
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
        
        Schema::table('ventas', function($table) {
            $table ->dropColumn([
                'saldo'
            ]);
        });
    }
}
