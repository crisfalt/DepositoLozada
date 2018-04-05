<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizeBotellasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('size_botellas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->string('descripcion',300)->nullable();
            $table->char('estado',1)->default('A');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('size_botellas');
    }
}
