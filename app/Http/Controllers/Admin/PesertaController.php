<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BiodataPeserta;
use App\Models\DokumenPeserta;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index()
    {
        $peserta = User::with('biodata')
            ->where('role', 'peserta')
            ->latest()
            ->paginate(10);

        return view('admin.peserta.index', compact('peserta'));
    }

    public function show($id)
    {
        $peserta = User::with(['biodata', 'dokumen'])
            ->where('role', 'peserta')
            ->findOrFail($id);

        return view('admin.peserta.show', compact('peserta'));
    }

    public function verifikasiBiodata(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:belum_lengkap,menunggu_verifikasi,lulus_verifikasi,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $biodata = BiodataPeserta::where('user_id', $id)->firstOrFail();

        $biodata->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Status verifikasi biodata berhasil diperbarui.');
    }

    public function verifikasiDokumen(Request $request, $id)
    {
        $request->validate([
            'status_dokumen' => 'required|in:menunggu,diterima,ditolak,revisi',
            'catatan_admin' => 'nullable|string',
        ]);

        $dokumen = DokumenPeserta::findOrFail($id);

        $dokumen->update([
            'status_dokumen' => $request->status_dokumen,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Status dokumen berhasil diperbarui.');
    }
}
