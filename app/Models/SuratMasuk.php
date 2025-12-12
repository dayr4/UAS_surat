<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_agenda',
        'nomor_surat_asal',
        'tanggal_surat',
        'tanggal_diterima',
        'asal_surat',
        'perihal',
        'kategori_id',
        'isi_ringkas',
        'lampiran_file',
        'created_by',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSurat::class);
    }

    public function disposisiTo()
    {
        return $this->belongsToMany(
            User::class,
            'surat_masuk_user',
            'surat_masuk_id',
            'user_id'
        )
        ->withPivot('status')
        ->withTimestamps();
    }
}
