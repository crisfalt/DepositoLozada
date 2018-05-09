<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrdenRutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orden_rutas', function (Blueprint $table) {
            //
            $table->dropForeign('orden_rutas_user_id_foreign');
            $table->dropColumn('user_id');
            $table->string('cliente_id',30)->after('orden');
            $table->foreign('cliente_id')->references('number_id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orden_rutas', function (Blueprint $table) {
            //
            $table->dropForeign('orden_rutas_cliente_foreign');
            $table->dropColumn('cliente_id');
            $table->integer('user_id')->unsigned()->after('orden');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
