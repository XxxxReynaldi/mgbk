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
        'id_user', 'nama_lengkap', 'alamat_sekolah', 'nama_kepala_sekolah',
        'asal_sekolah', 'tambahan_informasi', 'logo_sekolah'
    ];
}
