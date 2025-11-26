<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    public function index()
    {
        return response()->json(
            SuratMasuk::with('kategori')->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_agenda'      => 'required',
            'nomor_surat_asal'  => 'required',
            'tanggal_surat'     => 'required|date',
            'tanggal_diterima'  => 'required|date',
            'asal_surat'        => 'required',
            'perihal'           => 'required',
            'kategori_id'       => 'required|exists:kategori_surats,id',
            'isi_ringkas'       => 'nullable',
            'lampiran_file'     => 'nullable',
            'status_disposisi'  => 'nullable',
            'created_by'        => 'required|exists:users,id',
        ]);

        $surat = SuratMasuk::create($data);

        return response()->json($surat, 201);
    }

    public function show($id)
    {
        $surat = SuratMasuk::with('kategori')->findOrFail($id);
        return response()->json($surat);
    }

    public function update(Request $request, $id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $surat->update($request->all());

        return response()->json($surat);
    }

    public function destroy($id)
    {
        SuratMasuk::destroy($id);
        return response()->json(['message' => 'Data dihapus'], 200);
    }
}
