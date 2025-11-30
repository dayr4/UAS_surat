<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    // ============================================================
    // ===============  INDEX + FITUR PENCARIAN  ====================
    // ============================================================
    public function index(Request $request)
    {
        // Ambil kategori untuk dropdown filter
        $kategoris = KategoriSurat::all();

        // Query pencarian
        $query = SuratKeluar::with('kategori');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($w) use ($q) {
                $w->where('nomor_surat', 'like', "%$q%")
                ->orWhere('tujuan_surat', 'like', "%$q%")
                ->orWhere('perihal', 'like', "%$q%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $surats = $query->latest()->get();

        return view('surat_keluar.index', compact('surats', 'kategoris'));
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
            'status'        => 'required|string|max:50',
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
            'status'        => 'required|string|max:50',
        ]);

        if ($request->hasFile('lampiran_file')) {

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
