<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local', function (Blueprint $table) {
            $table->increments('id');  //Identificador
            $table->string('nombre');
            $table->string('direccion');
            $table->integer('celular');
            $table->time('horario_a');
            $table->time('horario_c');
            $table->boolean('abierto');
            $table->float('latitud', 16, 14);
            $table->float('longitud', 17, 14);
            $table->longtext('area');
            $table->timestamps();   // tiempo en el que se genera un registro (Nuevo, antiguo)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('local');
    }
}
