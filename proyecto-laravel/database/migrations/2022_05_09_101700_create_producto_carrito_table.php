<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoCarritoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_carrito', function (Blueprint $table) {
            $table->integer('id_producto')->unsigned();
            $table->integer('id_carrito')->unsigned();
            $table->integer('cantidad');
            $table->primary(['id_producto','id_carrito']);

            $table->foreign('id_producto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_carrito')->references('id')->on('carrito')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_carrito');
    }
}
