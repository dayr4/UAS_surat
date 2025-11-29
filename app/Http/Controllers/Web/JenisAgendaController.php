<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\JenisAgenda;
use Illuminate\Http\Request;

class JenisAgendaController extends Controller
{
    public function index()
    {
        $jenis = JenisAgenda::latest()->get();
        return view('jenis_agenda.index', compact('jenis'));
    }

    public function create()
    {
        return view('jenis_agenda.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_jenis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        JenisAgenda::create($data);

        return redirect()->route('web.jenis-agenda.index')
                         ->with('success', 'Jenis agenda berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenis = JenisAgenda::findOrFail($id);
        return view('jenis_agenda.edit', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        $jenis = JenisAgenda::findOrFail($id);

        $data = $request->validate([
            'nama_jenis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $jenis->update($data);

        return redirect()->route('web.jenis-agenda.index')
                         ->with('success', 'Jenis agenda berhasil diperbarui.');
    }

    public function destroy($id)
    {
        JenisAgenda::destroy($id);

        return redirect()->route('web.jenis-agenda.index')
                         ->with('success', 'Jenis agenda berhasil dihapus.');
    }
}
