<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = "laporan";
    protected $primaryKey = "id_laporan";
    protected $fillable =
    [
        'id_user', 'id_sekolah', 'id_kegiatan', 'tgl_transaksi',
        'detail', 'upload_doc_1', 'upload_doc_2', 'upload_doc_3',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan');
    }
}
