<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AgendaKegiatan;
use App\Models\JenisAgenda;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class AgendaKegiatanController extends Controller
{
    public function index()
    {
        $agenda = AgendaKegiatan::with(['jenis'])->latest()->get();
        return view('agenda.index', compact('agenda'));
    }

    public function create()
    {
        return view('agenda.create', [
            'jenis'       => JenisAgenda::all(),   // <-- diperbaiki
            'suratMasuk'  => SuratMasuk::all(),
            'suratKeluar' => SuratKeluar::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'jenis_agenda_id' => 'required|exists:jenis_agendas,id',
            'waktu_mulai'     => 'required|date',
            'waktu_selesai'   => 'required|date|after_or_equal:waktu_mulai',
            'tempat'          => 'required|string|max:255',
            'keterangan'      => 'nullable|string',
            'status'          => 'required|string|max:50',
            'surat_masuk_id'  => 'nullable|exists:surat_masuks,id',
            'surat_keluar_id' => 'nullable|exists:surat_keluars,id',
        ]);

        $data['created_by'] = auth()->id();

        AgendaKegiatan::create($data);

        return redirect()->route('web.agenda.index')
                         ->with('success', 'Agenda berhasil disimpan.');
    }
}
