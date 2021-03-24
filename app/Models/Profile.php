<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // protected $table = "profiles";
    protected $primaryKey = "id_profile";
    protected $fillable =
    [
        'id_user', 'nama_lengkap', 'foto_profil', 'alamat_sekolah', 'nama_kepala_sekolah',
        'id_sekolah', 'tambahan_informasi', 'logo_sekolah'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah');
    }
}
