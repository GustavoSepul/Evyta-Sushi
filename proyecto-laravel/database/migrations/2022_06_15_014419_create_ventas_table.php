<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('numeroPedido')->unsigned();
            $table->date('fechaPedido');
            $table->string('direccionEntrega');
            $table->text('coordenadas');
            $table->text('destino');
            $table->enum('tipoPago',['debito','credito','prepago']);
            $table->integer('tarjeta');
            $table->integer('subtotal');
            $table->integer('total');
            $table->integer('id_usuario')->unsigned();
            $table->integer('id_cupon')->unsigned()->nullable();
            $table->integer('local_origen');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_cupon')->references('id')->on('cupon');
            $table->foreign('numeroPedido')->references('id')->on('carrito');
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
