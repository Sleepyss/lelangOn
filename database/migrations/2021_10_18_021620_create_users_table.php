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
            $table->id();
            $table->unsignedBigInteger('id_masyarakat');
            $table->unsignedBigInteger('id_petugas');
            $table->string('username');
            $table->string('password');
            $table->enum('level',['admin','petugas','masyarakat']);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_masyarakat')->references('id_masyarakat')->on('masyarakat');
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas');
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
