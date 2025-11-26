<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $surats = SuratKeluar::with('kategori')->latest()->get();
        return view('surat_keluar.index', compact('surats'));
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
        ]);

        $data['created_by'] = 1;

        SuratKeluar::create($data);

        return redirect()->route('web.surat-keluar.index')
                         ->with('success', 'Surat keluar berhasil disimpan');
    }
}
