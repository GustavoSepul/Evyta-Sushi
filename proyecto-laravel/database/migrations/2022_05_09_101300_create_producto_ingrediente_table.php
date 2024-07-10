<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoIngredienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_ingrediente', function (Blueprint $table) {
            $table->integer('id_producto')->unsigned();
            $table->integer('id_ingrediente')->unsigned();
            $table->primary(['id_producto','id_ingrediente']);

            $table->foreign('id_producto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_ingrediente')->references('id')->on('ingrediente')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_ingrediente');
    }
}
