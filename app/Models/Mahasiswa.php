<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nrp', 'nama', 'alamat', 'id_prodi', 'id_kelas', 'telp', 'photo'
    ];

    protected $hidden = [

    ];

    public function prodis()
    {
        return $this->belongsTo(Prodi::class,'id_prodi','id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'id_kelas','id');
    }


}
