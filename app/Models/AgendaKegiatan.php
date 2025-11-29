<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaKegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan',
        'jenis_agenda_id',
        'waktu_mulai',
        'waktu_selesai',
        'tempat',
        'keterangan',
        'status',
        'surat_masuk_id',
        'surat_keluar_id',
        'created_by',
    ];

    // Relasi ke jenis agenda
    public function jenis()
    {
        return $this->belongsTo(JenisAgenda::class, 'jenis_agenda_id');
    }

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    public function suratKeluar()
    {
        return $this->belongsTo(SuratKeluar::class);
    }
}
