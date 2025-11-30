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
    // ============================================================
    // ===============  INDEX + PENCARIAN  =========================
    // ============================================================
    public function index(Request $request)
    {
        // Ambil daftar jenis agenda untuk filter
        $jenisList = JenisAgenda::all();

        $query = AgendaKegiatan::with(['jenis']);

        // Pencarian berdasarkan nama & tempat
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($w) use ($q) {
                $w->where('nama_kegiatan', 'like', "%$q%")
                ->orWhere('tempat', 'like', "%$q%");
            });
        }

        // Filter berdasarkan jenis agenda
        if ($request->filled('jenis')) {
            $query->where('jenis_agenda_id', $request->jenis);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $agenda = $query->latest()->get();

        return view('agenda.index', compact('agenda', 'jenisList'));
    }

    public function create()
    {
        return view('agenda.create', [
            'jenis'       => JenisAgenda::all(),
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

    // ============================================================
    // ===============  EDIT AGENDA  ==============================
    // ============================================================
    public function edit($id)
    {
        return view('agenda.edit', [
            'agenda'      => AgendaKegiatan::findOrFail($id),
            'jenis'       => JenisAgenda::all(),
            'suratMasuk'  => SuratMasuk::all(),
            'suratKeluar' => SuratKeluar::all(),
        ]);
    }

    // ============================================================
    // ===============  UPDATE AGENDA  =============================
    // ============================================================
    public function update(Request $request, $id)
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

        AgendaKegiatan::where('id', $id)->update($data);

        return redirect()
            ->route('web.agenda.index')
            ->with('success', 'Agenda berhasil diperbarui.');
    }
}
