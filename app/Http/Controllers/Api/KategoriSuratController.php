<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;

class KategoriSuratController extends Controller
{
    public function index()
    {
        return response()->json(KategoriSurat::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required',
            'deskripsi'     => 'nullable',
        ]);

        $kategori = KategoriSurat::create($data);
        return response()->json($kategori, 201);
    }

    public function show($id)
    {
        return response()->json(KategoriSurat::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriSurat::findOrFail($id);
        $kategori->update($request->all());
        return response()->json($kategori);
    }

    public function destroy($id)
    {
        KategoriSurat::destroy($id);
        return response()->json(['message' => 'Data dihapus']);
    }
}
