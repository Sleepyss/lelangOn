<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lelangModel extends Model
{
    protected $table = 'lelang';
    protected $primaryKey = 'id_lelang';
    protected $fillable = [
        'id_barang','tgl_lelang','harga_akhir','id_petugas','status','id_masyarakat'
    ];
}
