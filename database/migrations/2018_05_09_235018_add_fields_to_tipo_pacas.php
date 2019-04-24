<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTipoPacas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tipo_pacas', function ($table) {
            $table->double('precio_envase')->nullable(); //se deja nullable para el administsrador pero en la vista se debe pedir como requerido
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipo_pacas', function ($table) {
            $table->dropColumn([
                'precio_envase',
            ]);
        });
    }
}
