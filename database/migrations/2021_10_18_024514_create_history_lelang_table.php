<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryLelangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_lelang', function (Blueprint $table) {
            $table->id('id_history');
            $table->unsignedBigInteger('id_lelang');
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_masyarakat');
            $table->integer('penawaran_harga');
            $table->timestamps();

            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->foreign('id_lelang')->references('id_lelang')->on('lelang');
            $table->foreign('id_masyarakat')->references('id_masyarakat')->on('masyarakat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_lelang');
    }
}
