<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliaSubfamiliaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familia_subfamilia', function (Blueprint $table) {
            $table->integer('id_familia')->unsigned();
            $table->integer('id_subfamilia')->unsigned();
            $table->primary(['id_familia','id_subfamilia']);

            $table->foreign('id_familia')->references('id')->on('familia')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_subfamilia')->references('id')->on('subfamilia')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('familia_subfamilia');
    }
}
