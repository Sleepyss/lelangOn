<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class petugasModel extends Model
{
    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas'; 
    protected $fillable = [
        'nama_petugas','tlp_petugas','alamat','jenis_kelamin'
    ];
}
