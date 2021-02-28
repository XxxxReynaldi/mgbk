<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = "sekolah";
    protected $primaryKey = "id_sekolah";
    protected $fillable =
    [
        'nama_sekolah', 'is_verified'
    ];

    public function laporan()
    {
        // return $this->hasOne(Profile::class, 'foreign_key', 'local_key');
        return $this->hasMany(Laporan::class, 'id_laporan');
    }
}
