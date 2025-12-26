<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use App\Models\KategoriSurat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    // ============================================================
    // ===================== LIST SURAT MASUK =====================
    // ============================================================
    public function index(Request $request)
    {
        $kategoris = KategoriSurat::all();

        $query = SuratMasuk::with(['kategori', 'disposisiTo']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
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

    // ============================================================
    // ===================== DETAIL SURAT =========================
    // ============================================================
    public function show($id)
    {
        $surat = SuratMasuk::with(['kategori', 'disposisiTo'])->findOrFail($id);
        return view('surat_masuk.show', compact('surat'));
    }

    // ============================================================
    // ===================== CRUD ADMIN ===========================
    // ============================================================
    public function create()
    {
        return view('surat_masuk.create', [
            'kategoris' => KategoriSurat::all()
        ]);
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
            $data['lampiran_file'] = $request->file('lampiran_file')
                ->store('lampiran', 'public');
        }

        SuratMasuk::create($data);

        return redirect()
            ->route('web.surat-masuk.index')
            ->with('success', 'Surat masuk berhasil disimpan');
    }

    public function edit($id)
    {
        return view('surat_masuk.edit', [
            'surat'     => SuratMasuk::findOrFail($id),
            'kategoris' => KategoriSurat::all(),
        ]);
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

            $data['lampiran_file'] = $request->file('lampiran_file')
                ->store('lampiran', 'public');
        }

        $surat->update($data);

        return redirect()
            ->route('web.surat-masuk.index')
            ->with('success', 'Surat masuk berhasil diupdate');
    }

    public function destroy($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        if ($surat->lampiran_file && Storage::disk('public')->exists($surat->lampiran_file)) {
            Storage::disk('public')->delete($surat->lampiran_file);
        }

        $surat->delete();

        return redirect()
            ->route('web.surat-masuk.index')
            ->with('success', 'Surat masuk berhasil dihapus');
    }

    // ============================================================
    // ================= DISPOSISI (ADMIN) ========================
    // ============================================================

    /**
     * ADMIN: tampilkan form pilih USER
     */
    public function disposisiForm($id)
    {
        return view('surat_masuk.disposisi', [
            'surat' => SuratMasuk::findOrFail($id),
            'users' => User::where('role', 'user')->get(),
        ]);
    }

    /**
     * ADMIN: simpan USER tujuan disposisi
     */
    public function disposisiStore(Request $request, $id)
    {
        $request->validate([
            'users'   => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        $surat = SuratMasuk::findOrFail($id);

        foreach ($request->users as $userId) {
            $surat->disposisiTo()->syncWithoutDetaching([
                $userId => [
                    'status' => 'Diproses'
                ]
            ]);
        }

        return redirect()
            ->route('web.surat-masuk.index')
            ->with('success', 'Surat berhasil didisposisikan ke user');
    }

    // ============================================================
    // ================= DISPOSISI SAYA (USER) ====================
    // ============================================================
    public function disposisiSaya()
    {
        $surats = auth()->user()
            ->disposisiSurat()
            ->with('kategori')
            ->latest('surat_masuk_user.created_at')
            ->get();

        return view('surat_masuk.disposisi_saya', compact('surats'));
    }

    // ============================================================
    // ================= UPDATE STATUS (USER) =====================
    // ============================================================
    public function selesaikanDisposisi(SuratMasuk $surat)
    {
        auth()->user()
            ->disposisiSurat()
            ->updateExistingPivot($surat->id, [
                'status' => 'Selesai'
            ]);

        return back()->with('success', 'Disposisi ditandai selesai');
    }
}
