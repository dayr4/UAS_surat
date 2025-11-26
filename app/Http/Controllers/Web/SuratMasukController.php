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
        ]);

        // sementara: set created_by = 1
        $data['created_by'] = 1;

        SuratMasuk::create($data);

        return redirect()->route('web.surat-masuk.index')
                         ->with('success', 'Surat masuk berhasil disimpan');
    }
}
