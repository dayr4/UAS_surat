<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;

class KategoriSuratController extends Controller
{
    public function index()
    {
        $kategoris = KategoriSurat::latest()->get();
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'keterangan'    => 'nullable|string',
        ]);

        KategoriSurat::create($data);

        return redirect()->route('web.kategori.index')
                         ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = KategoriSurat::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriSurat::findOrFail($id);

        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'keterangan'    => 'nullable|string',
        ]);

        $kategori->update($data);

        return redirect()->route('web.kategori.index')
                         ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        KategoriSurat::destroy($id);

        return redirect()->route('web.kategori.index')
                         ->with('success', 'Kategori berhasil dihapus');
    }
}
