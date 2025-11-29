<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_agenda',
        'nomor_surat',
        'tanggal_surat',
        'tujuan_surat',
        'perihal',
        'kategori_id',
        'isi_ringkas',
        'lampiran_file',
        'created_by'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSurat::class);
    }
}
