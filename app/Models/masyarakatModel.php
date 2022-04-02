<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class masyarakatModel extends Model
{
    protected $table = 'masyarakat';
    protected $primaryKey = 'id_masyarakat';
    protected $fillable = [
        'nama_masyarakat','tlp_masyarakat','alamat_masyarakat'
    ]; 
}
