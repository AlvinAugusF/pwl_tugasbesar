<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ruangan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ruangan'
    ];

    protected $hidden = [

    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class,'id_ruangan');
    }
}
