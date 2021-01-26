<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SekolahBaru extends Model
{
    use HasFactory;

    protected $table = "sekolah_baru";
    protected $primaryKey = "id_sekolah_baru";
    protected $fillable =
    [
        'nama_sekolah'
    ];
}
