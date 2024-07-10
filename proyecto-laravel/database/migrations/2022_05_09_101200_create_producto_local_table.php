<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoLocalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_local', function (Blueprint $table) {
            $table->integer('id_producto')->unsigned();
            $table->integer('id_local')->unsigned();
            $table->primary(['id_producto','id_local']);

            $table->foreign('id_producto')->references('id')->on('producto')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_local')->references('id')->on('local')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_local');
    }
}
