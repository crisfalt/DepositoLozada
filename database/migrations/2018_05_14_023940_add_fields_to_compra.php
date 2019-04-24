<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCompra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compras', function ($table) {
            //se deja nullable para el administsrador pero en la vista se debe pedir como requerido
            $table->integer('fk_vendedor')->unsigned(); //foranea a autoincremental
            $table->foreign('fk_vendedor')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compras', function ($table) {
            $table->dropColumn([
                'fk_vendedor',
            ]);
        });
    }
}
