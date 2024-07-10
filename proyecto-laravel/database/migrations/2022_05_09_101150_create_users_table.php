<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rut')->unsigned()->unique();
            $table->string('name');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('direccion');
            $table->float('latitud', 16, 14);
            $table->float('longitud', 17, 14);
            $table->string('entrega');
            $table->text('coordenadas')->nullable();
            $table->integer('celular');
            $table->integer('telefono')->nullable();
            $table->longText('imagen')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
