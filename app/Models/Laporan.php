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

    public function jmlKegiatan($id_user, $id_sekolah, $id_kegiatan, $year, $start_date, $end_date)
    {
        // $jml = Laporan::with(['user', 'sekolah', 'kegiatan'])
        // ->where('id_user', '$id_user')
        // ->where('id_sekolah', 'id_sekolah')
        // ->where('id_kegiatan', '$id_kegiatan')
        // ->whereYear('tgl_transaksi', $year)
        // ->whereBetween('tgl_transaksi', [$start_date, $end_date])
        // ->count();
    }
}
