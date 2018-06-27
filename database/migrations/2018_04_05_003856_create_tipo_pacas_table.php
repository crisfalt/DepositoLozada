<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoPacasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_pacas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->string('descripcion',300)->nullable();
            $table->integer('cantidad');
            $table->double('precio', 12 , 2)->nullable();
            $table->boolean('retornable')->default(false);
            $table->string('estado',1)->default('A');
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
        Schema::dropIfExists('tipo_pacas');
    }
}
