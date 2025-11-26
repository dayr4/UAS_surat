<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisAgenda;
use Illuminate\Http\Request;

class JenisAgendaController extends Controller
{
    public function index()
    {
        return response()->json(JenisAgenda::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_jenis' => 'required',
            'deskripsi'  => 'nullable',
        ]);

        $jenis = JenisAgenda::create($data);
        return response()->json($jenis, 201);
    }

    public function show($id)
    {
        return response()->json(JenisAgenda::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $jenis = JenisAgenda::findOrFail($id);
        $jenis->update($request->all());
        return response()->json($jenis);
    }

    public function destroy($id)
    {
        JenisAgenda::destroy($id);
        return response()->json(['message' => 'Data dihapus']);
    }
}
