<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        return response()->json(
            SuratKeluar::with('kategori')->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_agenda'  => 'required',
            'nomor_surat'   => 'required',
            'tanggal_surat' => 'required|date',
            'tujuan_surat'  => 'required',
            'perihal'       => 'required',
            'kategori_id'   => 'required|exists:kategori_surats,id',
            'isi_ringkas'   => 'nullable',
            'lampiran_file' => 'nullable',
            'created_by'    => 'required|exists:users,id',
        ]);

        $surat = SuratKeluar::create($data);

        return response()->json($surat, 201);
    }

    public function show($id)
    {
        return response()->json(
            SuratKeluar::with('kategori')->findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $surat = SuratKeluar::findOrFail($id);
        $surat->update($request->all());
        return response()->json($surat);
    }

    public function destroy($id)
    {
        SuratKeluar::destroy($id);
        return response()->json(['message' => 'Data dihapus'], 200);
    }
}
