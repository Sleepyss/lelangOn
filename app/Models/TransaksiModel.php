<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'id_lelang','id_petugas','id_barang','id_masyarakat','hargabarang','tgl_transaksi','pembayaran'
    ];
}
