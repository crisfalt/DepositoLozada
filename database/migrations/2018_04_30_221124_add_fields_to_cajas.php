<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCajas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('cajas', function ($table) {
            $table->boolean('ocupada')->default(false); //para mirar si esta ocupada la caja por alguien
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
        Schema::table('cajas', function ($table) {
            $table->dropColumn([
                'ocupada',
            ]);
        });
    }
}
