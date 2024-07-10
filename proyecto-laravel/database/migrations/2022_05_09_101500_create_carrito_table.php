<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarritoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrito', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subtotal');
            $table->integer('id_cupon')->unsigned()->nullable();
            $table->integer('total');
            $table->string('local_origen')->nullable();
            $table->string('destino')->nullable();
            $table->enum('estado',['por_pagar','pagado','en_reparto','entregado']);
            $table->integer('id_usuario')->unsigned();
            $table->timestamps();

            $table->foreign('id_cupon')->references('id')->on('cupon')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carrito');
    }
}
