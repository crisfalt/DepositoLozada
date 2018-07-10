<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AterColumnFkFacturaToTableDetallesVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalles_ventas', function ($table) {
            $table->string('fk_producto', 100)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalles_ventas', function (Blueprint $table) {
            $table->integer('fk_producto')->unsigned()->change();
        });
    }
}
