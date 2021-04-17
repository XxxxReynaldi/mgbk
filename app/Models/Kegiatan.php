<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = "kegiatan";
    protected $primaryKey = "id_kegiatan";
    protected $fillable =
    [
        'sasaran_kegiatan', 'kegiatan', 'satuan_kegiatan', 'uraian',
        'pelaporan', 'durasi', 'satuan_waktu', 'jumlah_pertemuan',
        'ekuivalen'
    ];

    public function laporan()
    {
        // return $this->hasOne(Profile::class, 'foreign_key', 'local_key');
        return $this->hasMany(Laporan::class, 'id_kegiatan');
    }
}
