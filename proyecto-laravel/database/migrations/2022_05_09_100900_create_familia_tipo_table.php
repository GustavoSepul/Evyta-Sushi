<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliaTipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familia_tipo', function (Blueprint $table) {
            $table->integer('id_familia')->unsigned();
            $table->integer('id_tipo')->unsigned();
            $table->primary(['id_familia','id_tipo']);

            $table->foreign('id_familia')->references('id')->on('familia')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_tipo')->references('id')->on('tipo')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('familia_tipo');
    }
}
