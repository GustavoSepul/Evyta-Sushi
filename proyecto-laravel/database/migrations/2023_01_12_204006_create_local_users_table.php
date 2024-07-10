<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_users', function (Blueprint $table) {
            $table->integer('id_local')->unsigned();
            $table->integer('id_users')->unsigned();
            $table->primary(['id_local','id_users']);

            $table->foreign('id_local')->references('id')->on('local')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('local_users');
    }
}
