<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    // ============================================================
    // ===============  INDEX + FITUR PENCARIAN  ====================
    // ============================================================
    public function index(Request $request)
    {
        // Ambil kategori untuk dropdown filter
        $kategoris = KategoriSurat::all();

        // Query pencarian + filter kategori
        $query = SuratMasuk::with('kategori');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($w) use ($q) {
                $w->where('nomor_agenda', 'like', "%$q%")
                ->orWhere('asal_surat', 'like', "%$q%")
                ->orWhere('perihal', 'like', "%$q%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $surats = $query->latest()->get();

        return view('surat_masuk.index', compact('surats', 'kategoris'));
    }

    public function show($id)
    {
        $surat = SuratMasuk::with('kategori')->findOrFail($id);
        return view('surat_masuk.show', compact('surat'));
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
            'lampiran_file'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data['created_by'] = auth()->id();

        if ($request->hasFile('lampiran_file')) {
            $data['lampiran_file'] = $request->file('lampiran_file')->store('lampiran', 'public');
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
            'lampiran_file'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('lampiran_file')) {

            if ($surat->lampiran_file && Storage::disk('public')->exists($surat->lampiran_file)) {
                Storage::disk('public')->delete($surat->lampiran_file);
            }

            $data['lampiran_file'] = $request->file('lampiran_file')->store('lampiran', 'public');
        }

        $surat->update($data);

        return redirect()->route('web.surat-masuk.index')
                         ->with('success', 'Surat masuk berhasil diupdate');
    }

    public function destroy($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        if ($surat->lampiran_file && Storage::disk('public')->exists($surat->lampiran_file)) {
            Storage::disk('public')->delete($surat->lampiran_file);
        }

        $surat->delete();

        return redirect()->route('web.surat-masuk.index')
                         ->with('success', 'Surat masuk berhasil dihapus');
    }

    // ============================================================
    // ===============  Fitur DISPOSISI Tambahan ===================
    // ============================================================
    public function disposisiForm($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        return view('surat_masuk.disposisi', compact('surat'));
    }

    public function disposisiStore(Request $request, $id)
    {
        $request->validate([
            'status_disposisi' => 'required|in:Menunggu,Diproses,Selesai',
        ]);

        $surat = SuratMasuk::findOrFail($id);

        $surat->update([
            'status_disposisi' => $request->status_disposisi,
            'tanggal_disposisi' => now(),
        ]);

        return redirect()
            ->route('web.surat-masuk.index')
            ->with('success', 'Status disposisi berhasil diperbarui!');
    }
}
