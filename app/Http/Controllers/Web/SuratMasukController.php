<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    public function index()
    {
        $surats = SuratMasuk::with('kategori')->latest()->get();
        return view('surat_masuk.index', compact('surats'));
    }

    public function create()
    {
        $kategoris = KategoriSurat::all();
        return view('surat_masuk.create', compact('kategoris'));
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
            'lampiran_file'     => 'nullable|file', // <--- untuk upload, dipakai nanti
        ]);

        $data['created_by'] = auth()->id() ?? 1;

        // lampiran nanti kita isi di bagian upload
        if ($request->hasFile('lampiran_file')) {
            $data['lampiran_file'] = $request->file('lampiran_file')
                                            ->store('lampiran', 'public');
        }

        SuratMasuk::create($data);

        return redirect()->route('web.surat-masuk.index')
                         ->with('success', 'Surat masuk berhasil disimpan');
    }

    public function edit($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $kategoris = KategoriSurat::all();
        return view('surat_masuk.edit', compact('surat', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $surat = SuratMasuk::findOrFail($id);

        $data = $request->validate([
            'nomor_agenda'      => 'required',
            'nomor_surat_asal'  => 'required',
            'tanggal_surat'     => 'required|date',
            'tanggal_diterima'  => 'required|date',
            'asal_surat'        => 'required',
            'perihal'           => 'required',
            'kategori_id'       => 'required|exists:kategori_surats,id',
            'isi_ringkas'       => 'nullable',
            'lampiran_file'     => 'nullable|file',
        ]);

        if ($request->hasFile('lampiran_file')) {
            $data['lampiran_file'] = $request->file('lampiran_file')
                                            ->store('lampiran', 'public');
        }

        $surat->update($data);

        return redirect()->route('web.surat-masuk.index')
                         ->with('success', 'Surat masuk berhasil diupdate');
    }

    public function destroy($id)
    {
        SuratMasuk::destroy($id);
        return redirect()->route('web.surat-masuk.index')
                         ->with('success', 'Surat masuk berhasil dihapus');
    }

}
