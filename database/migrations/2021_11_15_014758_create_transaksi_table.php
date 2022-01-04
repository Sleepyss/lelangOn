<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_petugas');
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_masyarakat');
            $table->integer('hargabarang');
            $table->date('tgl_transaksi');
            $table->enum('pembayaran',['sudah','belum']);

            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas');
            $table->foreign('id_masyarakat')->references('id_masyarakat')->on('masyarakat');
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
        Schema::dropIfExists('transaksi');
    }
}
