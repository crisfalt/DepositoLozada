<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::rename('venta', 'ventas');
        
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            //inicio foreign key
            $table->string('fk_cliente');//foranea a autoincremental
            $table->foreign('fk_cliente')->references('number_id')->on('clientes');//id campo primario de tabla padre categories nombre tabla padre
            //inicio foreign key
            $table->integer('fk_vendedor')->unsigned();//foranea a autoincremental
            $table->foreign('fk_vendedor')->references('id')->on('users');//id campo primario de tabla padre categories nombre tabla padre
            //inicio foreign key
            $table->integer('fk_estado_venta')->unsigned();//foranea a autoincremental
            $table->foreign('fk_estado_venta')->references('id')->on('estado_de_ventas');//id campo primario de tabla padre categories nombre tabla padre
            //inicio foreign key
            $table->integer('fk_bodega')->unsigned();//foranea a autoincremental
            $table->foreign('fk_bodega')->references('id')->on('bodegas');//id campo primario de tabla padre categories nombre tabla padre
            //inicio foreign key
            $table->integer('fk_forma_de_pago')->unsigned();//foranea a autoincremental
            $table->foreign('fk_forma_de_pago')->references('id')->on('formapagos');//id campo primario de tabla padre categories nombre tabla padre


            $table->double('total',12,2)->nullable();
            $table->double('saldo',12,2)->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->integer('numeroDias')->default(8);

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
        Schema::dropIfExists('ventas');
    }
}
