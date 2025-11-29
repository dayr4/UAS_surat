<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $surats = SuratKeluar::with('kategori')->latest()->get();
        return view('surat_keluar.index', compact('surats'));
    }

    public function show($id)
    {
        $surat = SuratKeluar::with('kategori')->findOrFail($id);
        return view('surat_keluar.show', compact('surat'));
    }

    public function create()
    {
        $kategoris = KategoriSurat::all();
        return view('surat_keluar.create', compact('kategoris'));
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
            'lampiran_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data['created_by'] = auth()->id();

        if ($request->hasFile('lampiran_file')) {
            $data['lampiran_file'] = $request->file('lampiran_file')
                                            ->store('lampiran', 'public');
        }

        SuratKeluar::create($data);

        return redirect()->route('web.surat-keluar.index')
                         ->with('success', 'Surat keluar berhasil disimpan');
    }

    public function edit($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        $kategoris = KategoriSurat::all();
        return view('surat_keluar.edit', compact('surat', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $surat = SuratKeluar::findOrFail($id);

        $data = $request->validate([
            'nomor_agenda'  => 'required',
            'nomor_surat'   => 'required',
            'tanggal_surat' => 'required|date',
            'tujuan_surat'  => 'required',
            'perihal'       => 'required',
            'kategori_id'   => 'required|exists:kategori_surats,id',
            'isi_ringkas'   => 'nullable',
            'lampiran_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('lampiran_file')) {

            // Hapus file lama
            if ($surat->lampiran_file && Storage::disk('public')->exists($surat->lampiran_file)) {
                Storage::disk('public')->delete($surat->lampiran_file);
            }

            $data['lampiran_file'] = $request->file('lampiran_file')
                                            ->store('lampiran', 'public');
        }

        $surat->update($data);

        return redirect()->route('web.surat-keluar.index')
                         ->with('success', 'Surat keluar berhasil diupdate');
    }

    public function destroy($id)
    {
        $surat = SuratKeluar::findOrFail($id);

        if ($surat->lampiran_file && Storage::disk('public')->exists($surat->lampiran_file)) {
            Storage::disk('public')->delete($surat->lampiran_file);
        }

        $surat->delete();

        return redirect()->route('web.surat-keluar.index')
                         ->with('success', 'Surat keluar berhasil dihapus');
    }
}
