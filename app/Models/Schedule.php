<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_prodi', 'id_ta', 'id_kelas', 'id_matkul', 'hari', 'waktu', 'id_ruangan'
    ];

    protected $hidden = [

    ];

    public function matkul()
    {
        return $this->belongsTo(Matkul::class,'id_matkul','id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class,'id_ruangan','id');
    }


    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'id_kelas','id');
    }

    public function krs()
    {
        return $this->hasMany(Krs::class,'id_schedule');
    }

}
