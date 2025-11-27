<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AgendaKegiatan;
use App\Models\JenisAgenda;
use Illuminate\Http\Request;

class AgendaKegiatanController extends Controller
{
    public function index()
    {
        // kelompokkan per tanggal untuk kesan "kalender"
        $agendas = AgendaKegiatan::with('jenisAgenda')
            ->orderBy('waktu_mulai')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->waktu_mulai)->toDateString();
            });

        return view('agenda.index', compact('agendas'));
    }

    public function create()
    {
        $jenis = JenisAgenda::all();
        return view('agenda.create', compact('jenis'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kegiatan'   => 'required',
            'jenis_agenda_id' => 'required|exists:jenis_agendas,id',
            'waktu_mulai'     => 'required|date',
            'waktu_selesai'   => 'required|date',
            'tempat'          => 'required',
            'keterangan'      => 'nullable',
            'status'          => 'nullable',
        ]);

        $data['created_by'] = auth()->id() ?? 1;

        AgendaKegiatan::create($data);

        return redirect()->route('web.agenda.index')
                         ->with('success', 'Agenda berhasil dibuat');
    }
}
