<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    protected $table = 'matakuliah';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nama',
        'sks',
        'semester',
        'prodi',
    ];
}
