<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AgendaKegiatan;
use Illuminate\Http\Request;

class AgendaKegiatanController extends Controller
{
    public function index()
    {
        return response()->json(
            AgendaKegiatan::with(['jenisAgenda', 'suratMasuk', 'suratKeluar'])
                ->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kegiatan'   => 'required',
            'jenis_agenda_id' => 'required|exists:jenis_agendas,id',
            'waktu_mulai'     => 'required|date',
            'waktu_selesai'   => 'required|date',
            'tempat'          => 'required',
            'keterangan'      => 'nullable',
            'status'          => 'nullable',
            'surat_masuk_id'  => 'nullable|exists:surat_masuks,id',
            'surat_keluar_id' => 'nullable|exists:surat_keluars,id',
            'created_by'      => 'required|exists:users,id',
        ]);

        $agenda = AgendaKegiatan::create($data);
        return response()->json($agenda, 201);
    }

    public function show($id)
    {
        return response()->json(
            AgendaKegiatan::with(['jenisAgenda','suratMasuk','suratKeluar'])
                ->findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $agenda = AgendaKegiatan::findOrFail($id);
        $agenda->update($request->all());
        return response()->json($agenda);
    }

    public function destroy($id)
    {
        AgendaKegiatan::destroy($id);
        return response()->json(['message' => 'Data dihapus']);
    }
}
