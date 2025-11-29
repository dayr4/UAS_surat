<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisAgenda extends Model
{
    protected $fillable = [
        'nama_jenis',
        'deskripsi'
    ];

    public $timestamps = true;
}
